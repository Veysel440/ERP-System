"use client";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api } from "@/lib/axios";
import Link from "next/link";

export default function PurchasesPage(){
    const qc = useQueryClient();
    const { data, isLoading } = useQuery({
        queryKey: ["purchases"],
        queryFn: async ()=> (await api.get("/purchases")).data, // Resource collection
    });

    const del = useMutation({
        mutationFn: async (id:number)=> api.delete(`/purchases/${id}`),
        onSuccess: ()=> qc.invalidateQueries({ queryKey:["purchases"] }),
    });

    if (isLoading) return <div className="p-6">Yükleniyor…</div>;

    return (
        <div className="p-6 space-y-4">
            <div className="flex items-center justify-between">
                <h1 className="text-xl font-semibold">Satın Almalar</h1>
                <Link href="/purchases/new" className="text-blue-600">Yeni</Link>
            </div>
            <div className="space-y-2">
                {data?.data?.map((p:any)=>(
                    <div key={p.id} className="border rounded p-3 flex items-center justify-between">
                        <div>
                            <div className="font-medium">{p.product?.name ?? `Ürün #${p.product_id}`}</div>
                            <div className="text-sm text-gray-500">
                                Tedarikçi: {p.supplier?.name ?? `#${p.supplier_id}`} · Adet: {p.quantity} · Tutar: {p.total_price} · Tarih: {p.purchase_date}
                            </div>
                        </div>
                        <div className="flex gap-3">
                            <Link href={`/purchases/${p.id}`} className="text-blue-600">Düzenle</Link>
                            <button className="text-red-600" onClick={()=>del.mutate(p.id)}>Sil</button>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
