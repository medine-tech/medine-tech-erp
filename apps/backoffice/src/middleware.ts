import { NextResponse } from "next/server";
import type { NextRequest } from "next/server";

export function middleware(req: NextRequest) {
    const token = req.cookies.get("authToken")?.value;

    const isAuthRoute = req.nextUrl.pathname.startsWith("/login");
    const isProtectedRoute = req.nextUrl.pathname.startsWith("/dashboard");

    if (isProtectedRoute && !token) {
        const loginUrl = new URL("/login", req.url);
        return NextResponse.redirect(loginUrl);
    }

    if (isAuthRoute && token) {
        return NextResponse.redirect(new URL("/dashboard", req.url));
    }

    return NextResponse.next();
}

export const config = {
    matcher: ["/dashboard/:path*", "/login"],
};
