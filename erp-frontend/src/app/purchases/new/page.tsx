"use client";
import { useForm } from "react-hook-form";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Input from "@/components/ui/Input";
import Select from "@/components/ui/Select";
import { useRouter } from "next/navigation";

type Form = {
    supplier_id:number;
    product_id:number;
    quantity:number;
    total_price:number;
    purchase_date:string;
};

export default function PurchaseCreate(){
    const { register, handleSubmit } = useForm<Form>();
    const router = useRouter();
    const qc = useQueryClient();

    const suppliers = useQuery({
        queryKey: ["suppliers","all"],
        queryFn: async ()=> (await api.get("/suppliers?per_page=100")).data,
    });
    const products = useQuery({
        queryKey: ["products","all"],
        queryFn: async ()=> (await api.get("/products?per_page=100")).data,
    });

    const create = useMutation({
        mutationFn: async (v:Form)=> (await api.post("/purchases", v)).data,
        onSuccess: ()=>{
            qc.invalidateQueries({ queryKey:["purchases"] });
            router.replace("/purchases");
        }
    });

    const supplierOpts = (suppliers.data?.data ?? suppliers.data ?? []).map((s:any)=>({value:s.id,label:s.name}));
    const productOpts  = (products.data?.data  ?? products.data  ?? []).map((p:any)=>({value:p.id,label:p.name}));

    return (
        <div className="p-6 max-w-xl space-y-3">
            <h1 className="text-xl font-semibold">Yeni Satın Alma</h1>
            <form onSubmit={handleSubmit((v)=>create.mutate(v))} className="space-y-3">
                <Select {...register("supplier_id",{required:true, valueAsNumber:true})} options={supplierOpts}/>
                <Select {...register("product_id",{required:true, valueAsNumber:true})}  options={productOpts}/>
                <Input placeholder="Adet" type="number" step="1" {...register("quantity",{required:true, valueAsNumber:true})}/>
                <Input placeholder="Toplam Tutar" type="number" step="0.01" {...register("total_price",{required:true, valueAsNumber:true})}/>
                <Input placeholder="Tarih" type="date" {...register("purchase_date",{required:true})}/>
                <button className="px-4 py-2 rounded bg-black text-white">Kaydet</button>
            </form>
        </div>
    );
}
