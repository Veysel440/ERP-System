"use client";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Link from "next/link";

export default function FinanceList(){
    const qc = useQueryClient();
    const { data, isLoading } = useQuery({
        queryKey: ["finance-transactions"],
        queryFn: async ()=> (await api.get("/finance-transactions")).data, // Resource collection
    });

    const del = useMutation({
        mutationFn: async (id:number)=> api.delete(`/finance-transactions/${id}`),
        onSuccess: ()=> qc.invalidateQueries({ queryKey:["finance-transactions"] }),
    });

    if (isLoading) return <div className="p-6">Yükleniyor…</div>;

    return (
        <div className="p-6 space-y-4">
            <div className="flex items-center justify-between">
                <h1 className="text-xl font-semibold">Finansal İşlemler</h1>
                <Link href="/finance-transactions/new" className="text-blue-600">Yeni</Link>
            </div>

            <div className="space-y-2">
                {data?.data?.map((t:any)=>(
                    <div key={t.id} className="border rounded p-3 flex items-center justify-between">
                        <div>
                            <div className="font-medium">{t.type} · {t.amount}</div>
                            <div className="text-sm text-gray-500">
                                Tarih: {t.transaction_date} · Kullanıcı: {t.user?.name ?? `#${t.user_id}`}
                            </div>
                        </div>
                        <div className="flex gap-3">
                            <Link href={`/finance-transactions/${t.id}`} className="text-blue-600">Düzenle</Link>
                            <button className="text-red-600" onClick={()=>del.mutate(t.id)}>Sil</button>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
