import { zodResolver } from "@hookform/resolvers/zod";
import { useNavigate } from "@tanstack/react-router";
import { useState } from "react";
import { useForm } from "react-hook-form";
import { toast } from "sonner";
import { v4 as uuidv4 } from "uuid";

import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { companyService } from "@/lib/services/company";
import { type FirstCompanyFormValues, firstCompanySchema } from "@/lib/validations/auth";

import medineLogoSrc from "../assets/medine-logo.svg";
import { Link } from "../components/Link";
import { ApiError } from "../lib/services/auth";

export function FirstCompanyRegister() {
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<FirstCompanyFormValues>({
    resolver: zodResolver(firstCompanySchema),
    defaultValues: {
      companyId: uuidv4(),
      companyName: "",
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
    },
  });

  const onSubmit = async (data: FirstCompanyFormValues) => {
    setLoading(true);

    try {
      await companyService.registerFirstCompany(data);

      toast.success("Compañía registrada exitosamente", {
        description: "Tu cuenta ha sido creada. Por favor inicia sesión.",
      });

      // Redirigir al login después de un breve retraso para que el usuario vea el mensaje
      setTimeout(() => {
        void navigate({ to: "/login" });
      }, 2000);
    } catch (error) {
      const apiError = error as ApiError;
      console.error("Error al registrar compañía:", apiError);

      if (apiError.errors) {
        // Mostrar errores de validación específicos
        Object.entries(apiError.errors).forEach(([field, messages]) => {
          if (Array.isArray(messages) && messages.length > 0) {
            toast.error(`Error en ${field}`, {
              description: messages[0],
            });
          }
        });
      } else {
        // Mostrar error general
        toast.error(apiError.title || "Error al registrar", {
          description: apiError.detail || "Ha ocurrido un error al crear la compañía",
        });
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-slate-800 to-slate-900 flex flex-col">
      {/* Header simple */}
      <header className="bg-slate-900/80 backdrop-blur-sm text-white py-4 px-6 shadow-md">
        <div className="container mx-auto">
          <Link to="/" className="flex items-center gap-2 w-fit">
            <img src={medineLogoSrc} alt="Medine Logo" className="h-8 w-auto" />
            <span className="text-xl font-bold">MEDINE</span>
          </Link>
        </div>
      </header>

      {/* Contenido principal */}
      <main className="flex-grow flex items-center justify-center p-4">
        <div className="w-full max-w-md">
          <Card className="bg-white/10 border-slate-700 shadow-xl backdrop-blur-sm">
            <CardHeader className="space-y-1">
              <CardTitle className="text-2xl text-center text-white">Registrar Compañía</CardTitle>
              <CardDescription className="text-center text-slate-300">
                Crea tu primera compañía y tu cuenta de administrador
              </CardDescription>
            </CardHeader>
            <form onSubmit={handleSubmit(onSubmit)}>
              <CardContent className="space-y-4">
                {/* Campo oculto para el companyId */}
                <input type="hidden" id="companyId" {...register("companyId")} />

                {/* Datos de la compañía */}
                <div className="space-y-1">
                  <h3 className="text-sm font-medium text-slate-300">Datos de la compañía</h3>
                  <div className="h-px bg-slate-700/50 my-2" />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="companyName" className="text-white">
                    Nombre de la compañía
                  </Label>
                  <Input
                    id="companyName"
                    type="text"
                    placeholder="Mi Empresa S.A."
                    className={`bg-slate-800/50 border-slate-700 text-white placeholder:text-slate-400 ${
                      errors.companyName ? "border-red-500 focus-visible:ring-red-500" : ""
                    }`}
                    {...register("companyName")}
                  />
                  {errors.companyName && (
                    <p className="text-red-500 text-sm mt-1">{errors.companyName.message}</p>
                  )}
                </div>

                {/* Datos del administrador */}
                <div className="space-y-1 pt-2">
                  <h3 className="text-sm font-medium text-slate-300">Datos del administrador</h3>
                  <div className="h-px bg-slate-700/50 my-2" />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="name" className="text-white">
                    Nombre completo
                  </Label>
                  <Input
                    id="name"
                    type="text"
                    placeholder="Juan Pérez"
                    className={`bg-slate-800/50 border-slate-700 text-white placeholder:text-slate-400 ${
                      errors.name ? "border-red-500 focus-visible:ring-red-500" : ""
                    }`}
                    {...register("name")}
                  />
                  {errors.name && (
                    <p className="text-red-500 text-sm mt-1">{errors.name.message}</p>
                  )}
                </div>

                <div className="space-y-2">
                  <Label htmlFor="email" className="text-white">
                    Correo electrónico
                  </Label>
                  <Input
                    id="email"
                    type="email"
                    placeholder="nombre@empresa.com"
                    className={`bg-slate-800/50 border-slate-700 text-white placeholder:text-slate-400 ${
                      errors.email ? "border-red-500 focus-visible:ring-red-500" : ""
                    }`}
                    {...register("email")}
                  />
                  {errors.email && (
                    <p className="text-red-500 text-sm mt-1">{errors.email.message}</p>
                  )}
                </div>

                <div className="space-y-2">
                  <Label htmlFor="password" className="text-white">
                    Contraseña
                  </Label>
                  <Input
                    id="password"
                    type="password"
                    className={`bg-slate-800/50 border-slate-700 text-white ${
                      errors.password ? "border-red-500 focus-visible:ring-red-500" : ""
                    }`}
                    {...register("password")}
                  />
                  {errors.password && (
                    <p className="text-red-500 text-sm mt-1">{errors.password.message}</p>
                  )}
                </div>

                <div className="space-y-2">
                  <Label htmlFor="password_confirmation" className="text-white">
                    Confirmar contraseña
                  </Label>
                  <Input
                    id="password_confirmation"
                    type="password"
                    className={`bg-slate-800/50 border-slate-700 text-white ${
                      errors.password_confirmation
                        ? "border-red-500 focus-visible:ring-red-500"
                        : ""
                    }`}
                    {...register("password_confirmation")}
                  />
                  {errors.password_confirmation && (
                    <p className="text-red-500 text-sm mt-1">
                      {errors.password_confirmation.message}
                    </p>
                  )}
                </div>
              </CardContent>
              <CardFooter className="flex flex-col gap-4">
                <Button
                  type="submit"
                  className="w-full bg-sky-600 hover:bg-sky-700"
                  size="lg"
                  disabled={loading}
                >
                  {loading ? "Creando compañía..." : "Crear compañía"}
                </Button>
                <p className="text-sm text-center text-slate-400">
                  ¿Ya tienes una cuenta?{" "}
                  <Link to="/login" className="text-sky-400 hover:text-sky-300 font-medium">
                    Iniciar sesión
                  </Link>
                </p>
              </CardFooter>
            </form>
          </Card>
        </div>
      </main>

      {/* Footer simple */}
      <footer className="bg-slate-900 text-slate-400 py-4 text-center text-sm border-t border-slate-800">
        <div className="container mx-auto">
          © {new Date().getFullYear()} Medine. Todos los derechos reservados.
        </div>
      </footer>
    </div>
  );
}
