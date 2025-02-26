import { NextRequest, NextResponse } from "next/server";

import { auth } from "@/app/(auth)/actions/auth";

const publicRoutes = ["/login"];
const blockedPaths = ["/dashboard"];

export async function middleware(req: NextRequest): Promise<NextResponse> {
	const session = await auth();
	const pathname = req.nextUrl.pathname;
	const isPublicRoute = publicRoutes.some((route) => pathname.startsWith(route)) || pathname === "/";

	if (isPublicRoute) {
		if (session) {
			return NextResponse.redirect(new URL("/dashboard", req.url));
		}

		return NextResponse.next();
	}

	if (!session) {
		const loginUrl = new URL("/login", req.url);
		const callbackUrl = validateCallbackUrl(pathname);
		loginUrl.searchParams.set("callbackUrl", callbackUrl);

		return NextResponse.redirect(loginUrl);
	}

	return NextResponse.next();
}

function validateCallbackUrl(pathname: string): string {
	if (blockedPaths.includes(pathname)) {
		return "/dashboard";
	}

	return pathname;
}

export const config = {
	matcher: ["/((?!api|_next/static|_next/image|favicon.ico).*)"],
};
