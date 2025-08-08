"use client";
import axios from "axios";

const TOKEN_COOKIE = process.env.NEXT_PUBLIC_TOKEN_COOKIE || "erp_token";

export const api = axios.create({
    baseURL: process.env.NEXT_PUBLIC_API_URL,
});

api.interceptors.request.use((config) => {
    const token = document.cookie.split("; ").find(c=>c.startsWith(TOKEN_COOKIE+"="))?.split("=")[1];
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
});

api.interceptors.response.use(
    (r)=>r,
    (err)=>{
        if (err?.response?.status === 401 && typeof window !== "undefined") {
            document.cookie = `${TOKEN_COOKIE}=; Max-Age=0; path=/`;
            window.location.href = "/login";
        }
        return Promise.reject(err);
    }
);
