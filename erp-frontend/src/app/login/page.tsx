"use client";
import { useForm } from "react-hook-form";
import Button from "@/components/ui/Button";
import Input from "@/components/ui/Input";
import { useState } from "react";
import { useRouter } from "next/navigation";
import { useAuthStore } from "@/store/auth";

type Form = { email:string; password:string };

export default function LoginPage() {
    const { register, handleSubmit } = useForm<Form>();
    const login = useAuthStore(s=>s.login);
    const [err,setErr] = useState<string|null>(null);
    const router = useRouter();

    const onSubmit = async (v:Form) => {
        setErr(null);
        try {
            await login(v.email, v.password);
            router.replace("/dashboard");
        } catch (e:any) {
            setErr(e?.response?.data?.message ?? "Giriş başarısız");
        }
    };

    return (
        <div className="min-h-screen grid place-items-center">
            <form onSubmit={handleSubmit(onSubmit)} className="w-full max-w-sm space-y-3 p-6 border rounded">
                <h1 className="text-xl font-semibold">ERP Giriş</h1>
                {err && <div className="text-red-600 text-sm">{err}</div>}
                <Input placeholder="E-posta" type="email" {...register("email",{required:true})} />
                <Input placeholder="Şifre" type="password" {...register("password",{required:true})} />
                <Button type="submit">Giriş yap</Button>
            </form>
        </div>
    );
}
