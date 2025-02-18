"use client"

import { useForm } from "react-hook-form"
import { zodResolver } from "@hookform/resolvers/zod"
import { z } from "zod"
import { useRouter } from "next/navigation"
import toast, { Toaster } from "react-hot-toast"
import { login } from "@/app/actions/auth"
import Link from "next/link"
import { useEffect } from "react"

// Define the schema for form validation
const loginSchema = z.object({
    email: z.string().email("Ingresa un correo electrónico válido"),
    password: z.string().min(6, "La contraseña debe tener al menos 6 caracteres"),
})

// Infer the type from the schema
type LoginFormData = z.infer<typeof loginSchema>

export default function LoginPage() {
    const router = useRouter()

    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm<LoginFormData>({
        resolver: zodResolver(loginSchema),
    })

    useEffect(() => {
        const token = document.cookie
            .split("; ")
            .find(row => row.startsWith("authToken="))
            ?.split("=")[1];

        if (token) {
            router.push("/dashboard");
        }
    }, [router]);

    const onSubmit = async (data: LoginFormData) => {
        const result = await login(data);

        if (result.success && "token" in result) {
            document.cookie = `authToken=${result.token}; path=/; Secure; SameSite=Strict`;
            router.push("/dashboard");
        } else {
            toast.error(result.message)
            if (result.errors && typeof result.errors === "object") {
                Object.entries(result.errors).forEach(([field, messages]) => {
                    if (Array.isArray(messages)) {
                        messages.forEach((message) => console.error(message));
                    }
                });
            }
        }
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">
            <div className="max-w-md w-full space-y-8 p-8 bg-white rounded-xl shadow-md">
                <h2 className="mt-6 text-center text-3xl font-extrabold text-gray-900">Inicia sesión</h2>
                <form
                    className="mt-8 space-y-6"
                    onSubmit={handleSubmit(onSubmit)}
                >
                    <div className="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label htmlFor="email" className="sr-only">
                                Dirección de correo electrónico
                            </label>
                            <input
                                id="email"
                                type="email"
                                {...register("email")}
                                className="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Dirección de correo electrónico"
                            />
                            {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email.message}</p>}
                        </div>
                        <div>
                            <label htmlFor="password" className="sr-only">
                                Contraseña
                            </label>
                            <input
                                id="password"
                                type="password"
                                {...register("password")}
                                className="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Contraseña"
                            />
                            {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password.message}</p>}
                        </div>
                    </div>

                    <div>
                        <input type="hidden" name="redirectTo" />
                        <button
                            type="submit"
                            className="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Iniciar sesión
                        </button>
                        <Toaster />
                    </div>
                </form>
                <div className="text-sm text-center">
                    <Link href="#" className="font-medium text-indigo-600 hover:text-indigo-500">
                        ¿No tienes una cuenta? Regístrate aquí
                    </Link>
                </div>
            </div>
        </div>
    )
}

