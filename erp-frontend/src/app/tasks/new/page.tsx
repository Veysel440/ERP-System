"use client";
import { useForm } from "react-hook-form";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Input from "@/components/ui/Input";
import Select from "@/components/ui/Select";
import Button from "@/components/ui/Button";
import { useRouter } from "next/navigation";

type Form = {
    project_id:number;
    title:string;
    description?:string;
    status:"open"|"in_progress"|"completed"|"cancelled";
    assigned_to?:number|null;
};

export default function TaskCreate(){
    const { register, handleSubmit } = useForm<Form>({ defaultValues: { status: "open" } });
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

    const create = useMutation({
        mutationFn: async (v:Form)=> (await api.post("/tasks", v)).data,
        onSuccess: ()=>{
            qc.invalidateQueries({ queryKey:["tasks"] });
            router.replace("/tasks");
        }
    });

    const projectOpts = (projects.data?.data ?? projects.data ?? []).map((p:any)=>({ value:p.id, label:p.name }));
    const userOpts    = (users.data?.data    ?? users.data    ?? []).map((u:any)=>({ value:u.id, label:u.name }));

    return (
        <div className="p-6 max-w-xl space-y-3">
            <h1 className="text-xl font-semibold">Yeni Görev</h1>
            <form onSubmit={handleSubmit((v)=>create.mutate(v))} className="space-y-3">
                <Select {...register("project_id",{required:true, valueAsNumber:true})} options={projectOpts}/>
                <Input placeholder="Başlık" {...register("title",{required:true})}/>
                <Input placeholder="Açıklama" {...register("description")}/>
                <Select {...register("status",{required:true})} options={[
                    {value:"open", label:"Açık"},
                    {value:"in_progress", label:"Devam"},
                    {value:"completed", label:"Tamamlandı"},
                    {value:"cancelled", label:"İptal"},
                ]}/>
                <Select {...register("assigned_to",{valueAsNumber:true})} options={[{value:"",label:"Atama yok"}, ...userOpts]}/>
                <Button type="submit">Kaydet</Button>
            </form>
        </div>
    );
}
