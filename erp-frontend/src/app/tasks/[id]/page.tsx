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
    project_id:number;
    title:string;
    description?:string;
    status:"open"|"in_progress"|"completed"|"cancelled";
    assigned_to?:number|undefined;
};

export default function TaskEdit(){
    const params = useParams<{id:string}>();
    const id = Number(params.id);
    const { register, handleSubmit, reset } = useForm<Form>();
    const router = useRouter();
    const qc = useQueryClient();

    const projects = useQuery({
        queryKey: ["projects","all"],
        queryFn: async ()=> (await api.get("/projects?per_page=100")).data,
    });
    const users = useQuery({
        queryKey: ["users","all"],
        queryFn: async ()=> (await api.get("/users?per_page=100")).data,
    });

    const details = useQuery({
        queryKey: ["task", id],
        queryFn: async ()=> (await api.get(`/tasks/${id}`)).data,
    });

    // v5: onSuccess yerine useEffect
    useEffect(() => {
        const d = details.data;
        if (!d) return;
        reset({
            project_id: d.project_id,
            title: d.title,
            description: d.description ?? "",
            status: d.status,
            assigned_to: d.assigned_to ?? undefined,
        });
    }, [details.data, reset]);

    const update = useMutation({
        mutationFn: async (v:Form)=> (await api.put(`/tasks/${id}`, v)).data,
        onSuccess: ()=>{
            qc.invalidateQueries({ queryKey:["tasks"] });
            router.replace("/tasks");
        }
    });

    if (details.isLoading) return <div className="p-6">Yükleniyor…</div>;

    const projectOpts = (projects.data?.data ?? projects.data ?? []).map((p:any)=>({ value:p.id, label:p.name }));
    const userOpts    = (users.data?.data    ?? users.data    ?? []).map((u:any)=>({ value:u.id, label:u.name }));

    return (
        <div className="p-6 max-w-xl space-y-3">
            <h1 className="text-xl font-semibold">Görev Düzenle</h1>
            <form onSubmit={handleSubmit((v)=>update.mutate(v))} className="space-y-3">
                <Select
                    {...register("project_id", {
                        required:true,
                        setValueAs: (v)=> Number(v),
                    })}
                    options={projectOpts}
                />
                <Input placeholder="Başlık" {...register("title",{required:true})}/>
                <Input placeholder="Açıklama" {...register("description")}/>
                <Select
                    {...register("status",{required:true})}
                    options={[
                        {value:"open", label:"Açık"},
                        {value:"in_progress", label:"Devam"},
                        {value:"completed", label:"Tamamlandı"},
                        {value:"cancelled", label:"İptal"},
                    ]}
                />
                <Select
                    {...register("assigned_to", {
                        setValueAs: (v)=> v === "" ? undefined : Number(v),
                    })}
                    options={[{value:"",label:"Atama yok"}, ...userOpts]}
                />
                <Button type="submit">Güncelle</Button>
            </form>
        </div>
    );
}
