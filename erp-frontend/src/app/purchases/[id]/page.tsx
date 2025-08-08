"use client";
import { useForm } from "react-hook-form";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Input from "@/components/ui/Input";
import Select from "@/components/ui/Select";
import { useRouter, useParams } from "next/navigation";
import { useEffect } from "react";

type Form = {
    supplier_id:number;
    product_id:number;
    quantity:number;
    total_price:number;
    purchase_date:string;
};

export default function PurchaseEdit(){
    const params = useParams<{id:string}>();
    const id = Number(params.id);
    const { register, handleSubmit, reset } = useForm<Form>();
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

    const details = useQuery({
        queryKey: ["purchase", id],
        queryFn: async ()=> (await api.get(`/purchases/${id}`)).data,
    });

    useEffect(() => {
        const d = details.data;
        if (!d) return;
        reset({
            supplier_id: d.supplier_id,
            product_id: d.product_id,
            quantity: Number(d.quantity),
            total_price: Number(d.total_price),
            purchase_date: d.purchase_date,
        });
    }, [details.data, reset]);

    const update = useMutation({
        mutationFn: async (v:Form)=> (await api.put(`/purchases/${id}`, v)).data,
        onSuccess: ()=>{
            qc.invalidateQueries({ queryKey:["purchases"] });
            router.replace("/purchases");
        }
    });

    if (details.isLoading) return <div className="p-6">Yükleniyor…</div>;

    const supplierOpts = (suppliers.data?.data ?? suppliers.data ?? []).map((s:any)=>({value:s.id,label:s.name}));
    const productOpts  = (products.data?.data  ?? products.data  ?? []).map((p:any)=>({value:p.id,label:p.name}));

    return (
        <div className="p-6 max-w-xl space-y-3">
            <h1 className="text-xl font-semibold">Satın Alma Düzenle</h1>
            <form onSubmit={handleSubmit((v)=>update.mutate(v))} className="space-y-3">
                <Select {...register("supplier_id",{required:true, valueAsNumber:true})} options={supplierOpts}/>
                <Select {...register("product_id",{required:true, valueAsNumber:true})}  options={productOpts}/>
                <Input placeholder="Adet" type="number" step="1" {...register("quantity",{required:true, valueAsNumber:true})}/>
                <Input placeholder="Toplam Tutar" type="number" step="0.01" {...register("total_price",{required:true, valueAsNumber:true})}/>
                <Input placeholder="Tarih" type="date" {...register("purchase_date",{required:true})}/>
                <button className="px-4 py-2 rounded bg-black text-white">Güncelle</button>
            </form>
        </div>
    );
}
