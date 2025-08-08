"use client";
import { useForm } from "react-hook-form";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Input from "@/components/ui/Input";
import Select from "@/components/ui/Select";
import Button from "@/components/ui/Button";
import { useRouter } from "next/navigation";

type Form = {
    type:"income"|"expense";
    amount:number;
    description?:string;
    transaction_date:string;
    user_id:number;
};

export default function FinanceCreate(){
    const { register, handleSubmit } = useForm<Form>({ defaultValues: { type: "income" } });
    const router = useRouter();
    const qc = useQueryClient();

    const users = useQuery({
        queryKey: ["users","all"],
        queryFn: async ()=> (await api.get("/users?per_page=100")).data,
    });

    const create = useMutation({
        mutationFn: async (v:Form)=> (await api.post("/finance-transactions", v)).data,
        onSuccess: ()=>{
            qc.invalidateQueries({ queryKey:["finance-transactions"] });
            router.replace("/finance-transactions");
        }
    });

    const userOpts = (users.data?.data ?? users.data ?? []).map((u:any)=>({ value:u.id, label:u.name }));

    return (
        <div className="p-6 max-w-xl space-y-3">
            <h1 className="text-xl font-semibold">Yeni Finansal İşlem</h1>
            <form onSubmit={handleSubmit((v)=>create.mutate(v))} className="space-y-3">
                <Select
                    {...register("type",{required:true})}
                    options={[
                        {value:"income", label:"Gelir"},
                        {value:"expense", label:"Gider"},
                    ]}
                />
                <Input placeholder="Tutar" type="number" step="0.01" {...register("amount",{required:true, valueAsNumber:true})}/>
                <Input placeholder="Açıklama" {...register("description")} />
                <Input placeholder="Tarih" type="date" {...register("transaction_date",{required:true})} />
                <Select
                    {...register("user_id",{required:true, setValueAs:(v)=> Number(v)})}
                    options={userOpts}
                />
                <Button type="submit">Kaydet</Button>
            </form>
        </div>
    );
}
