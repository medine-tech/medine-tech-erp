"use client";

import { zodResolver } from "@hookform/resolvers/zod";
import { ArrowLeft, AtSignIcon, Info, LockIcon, UserIcon } from "lucide-react";
import Link from "next/link";
import { useState } from "react";
import { useForm } from "react-hook-form";
import { toast } from "sonner";
import { z } from "zod";

import MedineLogo from "@/components/medine-logo";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardFooter, CardHeader } from "@/components/ui/card";
import { Form, FormControl, FormField, FormItem, FormMessage } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from "@/components/ui/tooltip";
import { cn } from "@/lib/utils";

const registerSchema = z
  .object({
    username: z.string().min(3, "El nombre de usuario debe tener al menos 3 caracteres"),
    email: z.string().email("Correo electrónico inválido"),
    password: z
      .string()
      .min(8, "La contraseña debe tener al menos 8 caracteres")
      .regex(
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/,
        "La contraseña debe contener al menos una mayúscula, una minúscula y un número",
      ),
    confirmPassword: z.string(),
  })
  .refine((data) => data.password === data.confirmPassword, {
    message: "Las contraseñas no coinciden",
    path: ["confirmPassword"],
  });

type RegisterFormValues = z.infer<typeof registerSchema>;

export default function RegisterPage() {
  const [isLoading, setIsLoading] = useState(false);
  const currentYear = new Date().getFullYear();

  const form = useForm<RegisterFormValues>({
    resolver: zodResolver(registerSchema),
    defaultValues: {
      username: "",
      email: "",
      password: "",
      confirmPassword: "",
    },
  });

  async function onSubmit(_data: RegisterFormValues) {
    setIsLoading(true);
    try {
      // console.log(data);
      toast.success("Registro exitoso");
    } catch (_error) {
      toast.error("Error al registrar la empresa");
    } finally {
      setIsLoading(false);
    }
  }

  return (
    <div className="flex min-h-screen flex-col items-center justify-center bg-gray-50/50">
      <div className="w-full max-w-md px-4">
        <div className="mb-8">
          <Link
            href="/"
            className="inline-flex items-center text-sm text-muted-foreground hover:text-primary transition-colors mb-4"
          >
            <ArrowLeft className="mr-2 h-4 w-4" />
            Volver al Inicio
          </Link>
          <div className="flex justify-center">
            <MedineLogo width={200} height={100} />
          </div>
        </div>

        <Card className="border-none shadow-lg">
          <CardHeader className="space-y-1 pb-6">
            <h1 className="text-2xl font-bold text-center">Registrar Empresa</h1>
            <p className="text-center text-muted-foreground text-sm">
              Crea una cuenta para tu empresa
            </p>
          </CardHeader>
          <CardContent>
            <Form {...form}>
              <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-5">
                <TooltipProvider delayDuration={300}>
                  <FormField
                    control={form.control}
                    name="username"
                    render={({ field }) => (
                      <FormItem>
                        <FormControl>
                          <div
                            className={cn(
                              "group relative transition-all duration-300",
                              "focus-within:ring-2 focus-within:ring-primary/20 rounded-lg",
                            )}
                          >
                            <UserIcon className="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-muted-foreground/60 transition-colors group-focus-within:text-primary" />
                            <Input
                              placeholder="Nombre de Usuario"
                              className="border-none pl-11 bg-gray-50/50 h-12 text-base placeholder:text-muted-foreground/80"
                              {...field}
                            />
                            <Tooltip>
                              <TooltipTrigger asChild>
                                <Info className="absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground/40 cursor-help" />
                              </TooltipTrigger>
                              <TooltipContent>
                                <p>Mínimo 3 caracteres</p>
                              </TooltipContent>
                            </Tooltip>
                          </div>
                        </FormControl>
                        <FormMessage className="ml-1 text-xs animate-in fade-in-50 slide-in-from-top-1" />
                      </FormItem>
                    )}
                  />

                  <FormField
                    control={form.control}
                    name="email"
                    render={({ field }) => (
                      <FormItem>
                        <FormControl>
                          <div
                            className={cn(
                              "group relative transition-all duration-300",
                              "focus-within:ring-2 focus-within:ring-primary/20 rounded-lg",
                            )}
                          >
                            <AtSignIcon className="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-muted-foreground/60 transition-colors group-focus-within:text-primary" />
                            <Input
                              type="email"
                              placeholder="Correo Electrónico"
                              className="border-none pl-11 bg-gray-50/50 h-12 text-base placeholder:text-muted-foreground/80"
                              {...field}
                            />
                            <Tooltip>
                              <TooltipTrigger asChild>
                                <Info className="absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground/40 cursor-help" />
                              </TooltipTrigger>
                              <TooltipContent>
                                <p>Correo electrónico de la empresa</p>
                              </TooltipContent>
                            </Tooltip>
                          </div>
                        </FormControl>
                        <FormMessage className="ml-1 text-xs animate-in fade-in-50 slide-in-from-top-1" />
                      </FormItem>
                    )}
                  />

                  <FormField
                    control={form.control}
                    name="password"
                    render={({ field }) => (
                      <FormItem>
                        <FormControl>
                          <div
                            className={cn(
                              "group relative transition-all duration-300",
                              "focus-within:ring-2 focus-within:ring-primary/20 rounded-lg",
                            )}
                          >
                            <LockIcon className="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-muted-foreground/60 transition-colors group-focus-within:text-primary" />
                            <Input
                              type="password"
                              placeholder="Contraseña"
                              className="border-none pl-11 bg-gray-50/50 h-12 text-base placeholder:text-muted-foreground/80"
                              {...field}
                            />
                            <Tooltip>
                              <TooltipTrigger asChild>
                                <Info className="absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground/40 cursor-help" />
                              </TooltipTrigger>
                              <TooltipContent>
                                <p>Mínimo 8 caracteres</p>
                                <p>Al menos una mayúscula</p>
                                <p>Al menos una minúscula</p>
                                <p>Al menos un número</p>
                              </TooltipContent>
                            </Tooltip>
                          </div>
                        </FormControl>
                        <FormMessage className="ml-1 text-xs animate-in fade-in-50 slide-in-from-top-1" />
                      </FormItem>
                    )}
                  />

                  <FormField
                    control={form.control}
                    name="confirmPassword"
                    render={({ field }) => (
                      <FormItem>
                        <FormControl>
                          <div
                            className={cn(
                              "group relative transition-all duration-300",
                              "focus-within:ring-2 focus-within:ring-primary/20 rounded-lg",
                            )}
                          >
                            <LockIcon className="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-muted-foreground/60 transition-colors group-focus-within:text-primary" />
                            <Input
                              type="password"
                              placeholder="Confirmar Contraseña"
                              className="border-none pl-11 bg-gray-50/50 h-12 text-base placeholder:text-muted-foreground/80"
                              {...field}
                            />
                          </div>
                        </FormControl>
                        <FormMessage className="ml-1 text-xs animate-in fade-in-50 slide-in-from-top-1" />
                      </FormItem>
                    )}
                  />
                </TooltipProvider>

                <Button
                  type="submit"
                  className="w-full h-12 text-base font-medium"
                  disabled={isLoading}
                >
                  {isLoading ? (
                    <div className="flex items-center gap-2">
                      <div className="h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent" />
                      <span>Registrando...</span>
                    </div>
                  ) : (
                    "Registrar Empresa"
                  )}
                </Button>
              </form>
            </Form>
          </CardContent>
          <CardFooter className="flex flex-col space-y-4 pb-6">
            <div className="relative w-full">
              <div className="absolute inset-0 flex items-center">
                <span className="w-full border-t" />
              </div>
              <div className="relative flex justify-center text-xs uppercase">
                <span className="bg-background px-2 text-muted-foreground">
                  ¿Ya tienes una cuenta?
                </span>
              </div>
            </div>
            <Button variant="outline" className="w-full h-11" asChild>
              <Link href="/login">Iniciar Sesión</Link>
            </Button>
          </CardFooter>
        </Card>

        <div className="mt-6 text-center text-sm text-gray-500">
          Desarrollado por MedineTech © {currentYear}
        </div>
      </div>
    </div>
  );
}
