"use server";

import { z } from "zod";

import { auth, signIn, signOut } from "@/app/(auth)/actions/auth";

const loginSchema = z.object({
	email: z.string().email(),
	password: z.string().min(6),
});

export async function login(formData: z.infer<typeof loginSchema>): Promise<any> {
	try {
		// Validate the form data
		const { email, password } = loginSchema.parse(formData);

		await signIn("credentials", {
			email,
			password,
			// Needed to handle the redirect manually
			redirect: false,
		});

		return { success: true };
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
				Authorization: `Bearer ${await getAuthToken()}`,
			},
		});

		await signOut();
	} catch (error) {
		console.error("Logout error:", error);
	}
}

export async function getAuthToken(): Promise<string | undefined> {
	const session = await auth();

	return session?.user?.token;
}
