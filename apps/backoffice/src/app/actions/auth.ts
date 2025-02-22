"use server";

import { cookies } from "next/headers";
import { z } from "zod";

const loginSchema = z.object({
	email: z.string().email(),
	password: z.string().min(6),
});

export async function login(formData: z.infer<typeof loginSchema>): Promise<any> {
	try {
		// Validate the form data
		const validatedData = loginSchema.parse(formData);

		const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/login`, {
			method: "POST",
			headers: {
				accept: "application/json",
				"Content-Type": "application/json",
			},
			body: JSON.stringify(validatedData),
		});

		const data = await response.json();

		if (response.ok) {
			// Store the token in an HttpOnly cookie
			const cookieStore = await cookies();
			cookieStore.set("auth_token", data.token, {
				httpOnly: true,
				secure: process.env.NODE_ENV === "production",
				sameSite: "strict",
				maxAge: 60 * 60 * 24 * 7, // 1 week
				path: "/",
			});

			return { success: true };
		}

		return {
			success: false,
			message: "Credenciales inválidas",
			errors: data.errors || [],
		};
	} catch (error) {
		if (error instanceof z.ZodError) {
			return {
				success: false,
				message: "Error de validación",
				errors: error.errors.map((e) => e.message),
			};
		}
		console.error("Login error:", error);

		return {
			success: false,
			message: "Se produjo un error inesperado",
			errors: [],
		};
	}
}

export async function logout(): Promise<void> {
	try {
		// Invalidate the token on the server
		await fetch(`${process.env.NEXT_PUBLIC_API_URL}/logout`, {
			method: "POST",
			headers: {
				accept: "application/json",
				"Content-Type": "application/json",
			},
		});

		// Delete the token from the cookies
		const cookieStore = await cookies();
		cookieStore.delete("auth_token");
	} catch (error) {
		console.error("Logout error:", error);
	}
}

export async function getAuthToken(): Promise<string | undefined> {
	const cookieStore = await cookies();

	return cookieStore.get("auth_token")?.value;
}
