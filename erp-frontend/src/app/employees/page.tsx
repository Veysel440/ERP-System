"use client";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Link from "next/link";
import Button from "@/components/ui/Button";

export default function EmployeesPage(){
    const qc = useQueryClient();
    const { data, isLoading } = useQuery({
        queryKey: ["employees"],
        queryFn: async ()=> (await api.get("/employees")).data, // Laravel Resource collection
    });

    const del = useMutation({
        mutationFn: async (id:number)=> api.delete(`/employees/${id}`),
        onSuccess: ()=> qc.invalidateQueries({ queryKey:["employees"] }),
    });

    if (isLoading) return <div className="p-6">Yükleniyor…</div>;

    return (
        <div className="p-6 space-y-4">
            <div className="flex items-center justify-between">
                <h1 className="text-xl font-semibold">Çalışanlar</h1>
                <Link href="/employees/new"><Button>Yeni</Button></Link>
            </div>
            <div className="space-y-2">
                {data?.data?.map((e:any)=>(
                    <div key={e.id} className="border rounded p-3 flex items-center justify-between">
                        <div>
                            <div className="font-medium">{e.name}</div>
                            <div className="text-sm text-gray-500">{e.email} · {e.department?.name ?? "-"}</div>
                        </div>
                        <div className="flex gap-2">
                            <Link href={`/employees/${e.id}`} className="text-blue-600">Düzenle</Link>
                            <button className="text-red-600" onClick={()=>del.mutate(e.id)}>Sil</button>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
