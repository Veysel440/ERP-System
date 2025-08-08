"use client";
import { useForm } from "react-hook-form";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Input from "@/components/ui/Input";
import Select from "@/components/ui/Select";
import Button from "@/components/ui/Button";
import { useRouter, useParams } from "next/navigation";
import { useEffect } from "react";

type Form = { department_id:number; name:string; email:string; phone?:string; address?:string };

export default function EmployeeEdit(){
    const params = useParams<{id:string}>();
    const id = Number(params.id);
    const { register, handleSubmit, reset } = useForm<Form>();
    const router = useRouter();
    const qc = useQueryClient();

    const deps = useQuery({
        queryKey: ["departments","all"],
        queryFn: async ()=> (await api.get("/departments?per_page=100")).data,
    });

    const details = useQuery({
        queryKey: ["employee", id],
        queryFn: async ()=> (await api.get(`/employees/${id}`)).data,
    });

    useEffect(() => {
        const d = details.data;
        if (!d) return;
        reset({
            department_id: d.department_id,
            name: d.name,
            email: d.email,
            phone: d.phone ?? "",
            address: d.address ?? "",
        });
    }, [details.data, reset]);

    const update = useMutation({
        mutationFn: async (v:Form)=> (await api.put(`/employees/${id}`, v)).data,
        onSuccess: ()=>{
            qc.invalidateQueries({ queryKey:["employees"] });
            router.replace("/employees");
        }
    });

    if (details.isLoading) return <div className="p-6">Yükleniyor…</div>;

    const depOptions = (deps.data?.data ?? deps.data ?? []).map((d:any)=>({ value:d.id, label:d.name }));

    return (
        <div className="p-6 max-w-xl space-y-3">
            <h1 className="text-xl font-semibold">Çalışan Düzenle</h1>
            <form onSubmit={handleSubmit((v)=>update.mutate(v))} className="space-y-3">
                <Select {...register("department_id", { required:true, valueAsNumber:true })} options={depOptions}/>
                <Input placeholder="Ad Soyad" {...register("name",{required:true})} />
                <Input placeholder="E-posta" type="email" {...register("email",{required:true})} />
                <Input placeholder="Telefon" {...register("phone")} />
                <Input placeholder="Adres" {...register("address")} />
                <Button type="submit">Güncelle</Button>
            </form>
        </div>
    );
}
