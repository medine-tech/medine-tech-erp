import { NextResponse, NextRequest } from "next/server";

const publicRoutes = ["/login"];

export function middleware(req: NextRequest) {
    const token = req.cookies.get("authToken")?.value;

    const isPublicRoute = publicRoutes.some((route) => req.nextUrl.pathname.startsWith(route));


    if (isPublicRoute) {
        if (token) {
            return NextResponse.redirect(new URL("/dashboard", req.url));
        }

        return NextResponse.next();
    }

    if (!token) {
        const loginUrl = new URL("/login", req.url);
        loginUrl.searchParams.set("callbackUrl", req.url);

        return NextResponse.redirect(loginUrl);
    }

    return NextResponse.next();
}

export const config = {
    matcher: ["/((?!api|_next|static|favicon.ico|login).*)"],
};
