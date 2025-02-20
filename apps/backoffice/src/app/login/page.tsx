"use client"

import { useForm } from "react-hook-form"
import { zodResolver } from "@hookform/resolvers/zod"
import { z } from "zod"
import { useRouter } from "next/navigation"
import {
    toast,
    Toaster,
} from "sonner"
import { login } from "@/app/actions/auth"
import Link from "next/link"
import { loginSchema } from "@/app/utils/zodSchemas"
import {
    Form,
    FormItem,
    FormLabel,
    FormControl,
    FormField,
    FormMessage
} from "@/app/components/ui/form"
import { Input } from "@/app/components/ui/input"

export default function LoginPage() {
    const LoginFormData = useForm<z.infer<typeof loginSchema>>({
      resolver: zodResolver(loginSchema),
      defaultValues: {
        email: "",
        password: "",
      },
    })

    const router = useRouter()

    async function onSubmit(data: z.infer<typeof loginSchema>) {
        const result = await login(data);

        if (result.success) {
            router.push("/dashboard");
        } else {
            toast.error(result.message)
        }
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">
            <div className="max-w-md w-full space-y-8 p-8 bg-white rounded-xl shadow-md">
                <h2 className="mt-6 text-center text-3xl font-extrabold text-gray-900">Inicia sesión</h2>
                <Form {...LoginFormData}>
                    <form className="mt-8 space-y-6"
                    onSubmit={LoginFormData.handleSubmit(onSubmit)}
                    >

                        <FormField
                            name="email"
                            control={LoginFormData.control}
                            render={({ field }) => (
                                <FormItem>
                                    <FormLabel className="text-black">Correo Electrónico</FormLabel>
                                    <FormControl>
                                        <Input
                                            type="email"
                                            placeholder="Dirección de correo electrónico"
                                            className="text-black"
                                            {...field}
                                        />
                                    </FormControl>
                                    <FormMessage className="text-red-500 text-xs mt-1" />
                                </FormItem>
                            )}
                        />

                        <FormField
                            name="password"
                            control={LoginFormData.control}
                            render={({ field }) => (
                                <FormItem>
                                    <FormLabel className="text-black">Contraseña</FormLabel>
                                    <FormControl>
                                        <Input
                                            type="password"
                                            placeholder="Contraseña"
                                            className="text-black"
                                            {...field}
                                        />
                                    </FormControl>
                                    <FormMessage className="text-red-500 text-xs mt-1" />
                                </FormItem>
                            )}
                        />

                        <button
                            type="submit"
                            className="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Iniciar sesión
                        </button>
                        <Toaster />
                    </form>
                </Form>

                <div className="text-sm text-center">
                    <Link href="#" className="font-medium text-indigo-600 hover:text-indigo-500">
                        ¿No tienes una cuenta? Regístrate aquí
                    </Link>
                </div>
            </div>
        </div>
    )
}

