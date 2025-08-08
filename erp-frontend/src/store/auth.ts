"use client";
import { create } from "zustand";
import { api } from "@/lib/axios";

type User = { id:number; name:string; email:string };

type State = {
    user: User | null;
    token: string | null;
    login: (email:string, password:string) => Promise<void>;
    logout: () => void;
    me: () => Promise<void>;
};

const TOKEN_COOKIE = process.env.NEXT_PUBLIC_TOKEN_COOKIE || "erp_token";

export const useAuthStore = create<State>((set, get) => ({
    user: null,
    token: typeof document !== "undefined"
        ? (document.cookie.split("; ").find(c=>c.startsWith(TOKEN_COOKIE+"="))?.split("=")[1] ?? null)
        : null,

    login: async (email, password) => {
        const { data } = await api.post("/auth/login", { email, password });
        document.cookie = `${TOKEN_COOKIE}=${data.token}; path=/; SameSite=Lax`;
        set({ token: data.token, user: data.user });
    },

    logout: () => {
        document.cookie = `${TOKEN_COOKIE}=; Max-Age=0; path=/`;
        set({ token: null, user: null });
    },

    me: async () => {
        if (!get().token) return;
        const { data } = await api.get("/users/me");
        set({ user: data });
    },
}));
