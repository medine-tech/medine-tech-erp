import { NextRequest, NextResponse } from "next/server";

const publicRoutes = ["/login"];
const blockedPaths = ["/dashboard"];

export function middleware(req: NextRequest): NextResponse {
	const token = req.cookies.get("auth_token")?.value;

	const pathname = req.nextUrl.pathname;
	const isPublicRoute = publicRoutes.some((route) => pathname.startsWith(route)) || pathname === "/";

	if (isPublicRoute) {
		if (token) {
			return NextResponse.redirect(new URL("/dashboard", req.url));
		}

		return NextResponse.next();
	}

	if (!token) {
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
