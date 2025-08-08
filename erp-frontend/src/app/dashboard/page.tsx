"use client";
import { useQuery } from "@tanstack/react-query";
import { api } from "@/lib/axios";

export default function Dashboard() {
    const { data, isLoading, error } = useQuery({
        queryKey: ["summary"],
        queryFn: async () => (await api.get("/dashboard/summary")).data,
    });

    if (isLoading) return <div className="p-6">Yükleniyor…</div>;
    if (error) return <div className="p-6 text-red-600">Hata</div>;

    return (
        <div className="p-6 grid gap-4 grid-cols-2 md:grid-cols-4">
            <Card title="Gelir" value={data.income} />
            <Card title="Gider" value={data.expense} />
            <Card title="Çalışan" value={data.employee_count} />
            <Card title="Proje" value={data.project_count} />
        </div>
    );
}

function Card({title, value}:{title:string; value:any}) {
    return (
        <div className="border rounded p-4">
            <div className="text-sm text-gray-500">{title}</div>
            <div className="text-2xl font-semibold">{value}</div>
        </div>
    );
}
