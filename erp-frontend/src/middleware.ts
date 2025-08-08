import { NextResponse } from "next/server";
import type { NextRequest } from "next/server";

const TOKEN_COOKIE = process.env.TOKEN_COOKIE || "erp_token";
const protectedPaths = ["/", "/dashboard", "/tasks"];

export function middleware(req: NextRequest) {
    const { pathname } = req.nextUrl;
    const needsAuth = protectedPaths.some(p => pathname.startsWith(p));
    if (!needsAuth) return NextResponse.next();

    const token = req.cookies.get(TOKEN_COOKIE)?.value;
    if (!token) {
        const url = new URL("/login", req.url);
        return NextResponse.redirect(url);
    }
    return NextResponse.next();
}

export const config = {
    matcher: ["/", "/dashboard/:path*", "/tasks/:path*"],
};
