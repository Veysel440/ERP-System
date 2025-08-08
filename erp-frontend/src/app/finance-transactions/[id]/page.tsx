"use client";
import { useForm } from "react-hook-form";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Input from "@/components/ui/Input";
import Select from "@/components/ui/Select";
import Button from "@/components/ui/Button";
import { useRouter, useParams } from "next/navigation";
import { useEffect } from "react";

type Form = {
    type:"income"|"expense";
    amount:number;
    description?:string;
    transaction_date:string;
    user_id:number;
};

export default function FinanceEdit(){
    const params = useParams<{id:string}>();
    const id = Number(params.id);
    const { register, handleSubmit, reset } = useForm<Form>();
    const router = useRouter();
    const qc = useQueryClient();

    const users = useQuery({
        queryKey: ["users","all"],
        queryFn: async ()=> (await api.get("/users?per_page=100")).data,
    });

    const details = useQuery({
        queryKey: ["finance-transaction", id],
        queryFn: async ()=> (await api.get(`/finance-transactions/${id}`)).data,
    });

    useEffect(() => {
        const d = details.data;
        if (!d) return;
        reset({
            type: d.type,
            amount: Number(d.amount),
            description: d.description ?? "",
            transaction_date: d.transaction_date,
            user_id: d.user_id,
        });
    }, [details.data, reset]);

    const update = useMutation({
        mutationFn: async (v:Form)=> (await api.put(`/finance-transactions/${id}`, v)).data,
        onSuccess: ()=>{
            qc.invalidateQueries({ queryKey:["finance-transactions"] });
            router.replace("/finance-transactions");
        }
    });

    if (details.isLoading) return <div className="p-6">Yükleniyor…</div>;

    const userOpts = (users.data?.data ?? users.data ?? []).map((u:any)=>({ value:u.id, label:u.name }));

    return (
        <div className="p-6 max-w-xl space-y-3">
            <h1 className="text-xl font-semibold">Finansal İşlem Düzenle</h1>
            <form onSubmit={handleSubmit((v)=>update.mutate(v))} className="space-y-3">
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
                <Button type="submit">Güncelle</Button>
            </form>
        </div>
    );
}
