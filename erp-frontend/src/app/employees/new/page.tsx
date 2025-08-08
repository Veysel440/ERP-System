"use client";
import { useForm } from "react-hook-form";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Input from "@/components/ui/Input";
import Select from "@/components/ui/Select";
import Button from "@/components/ui/Button";
import { useRouter } from "next/navigation";

type Form = { department_id:number; name:string; email:string; phone?:string; address?:string };

export default function EmployeeCreate(){
    const { register, handleSubmit } = useForm<Form>();
    const router = useRouter();
    const qc = useQueryClient();

    const deps = useQuery({
        queryKey: ["departments","all"],
        queryFn: async ()=> (await api.get("/departments?per_page=100")).data, // basitçe tümünü al
    });

    const create = useMutation({
        mutationFn: async (v:Form)=> (await api.post("/employees", v)).data,
        onSuccess: ()=>{
            qc.invalidateQueries({ queryKey:["employees"] });
            router.replace("/employees");
        }
    });

    return (
        <div className="p-6 max-w-xl space-y-3">
            <h1 className="text-xl font-semibold">Yeni Çalışan</h1>
            <form onSubmit={handleSubmit((v)=>create.mutate(v))} className="space-y-3">
                <Select
                    {...register("department_id", { required:true, valueAsNumber:true })}
                    options={(deps.data?.data ?? deps.data)?.map((d:any)=>({ value:d.id, label:d.name })) ?? []}
                />
                <Input placeholder="Ad Soyad" {...register("name",{required:true})} />
                <Input placeholder="E-posta" type="email" {...register("email",{required:true})} />
                <Input placeholder="Telefon" {...register("phone")} />
                <Input placeholder="Adres" {...register("address")} />
                <Button type="submit">Kaydet</Button>
            </form>
        </div>
    );
}
