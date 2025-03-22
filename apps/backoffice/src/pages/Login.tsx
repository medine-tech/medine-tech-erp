import { zodResolver } from "@hookform/resolvers/zod";
import { useState } from "react";
import { useForm } from "react-hook-form";
import { Link, useNavigate } from "react-router-dom";

import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { type LoginFormValues, loginSchema } from "@/lib/validations/auth";

import medineLogoSrc from "../assets/medine-logo.svg";

export function Login() {
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<LoginFormValues>({
    resolver: zodResolver(loginSchema),
    defaultValues: {
      email: "",
      password: "",
      rememberMe: false,
    },
  });

  const onSubmit = async (data: LoginFormValues) => {
    setLoading(true);

    // Simulación de login - reemplazar con llamada real a API
    try {
      // Aquí implementarías la lógica de autenticación real
      console.log("Iniciando sesión con:", data);

      // Simular delay de autenticación
      await new Promise((resolve) => setTimeout(resolve, 1000));

      // Simular éxito
      navigate("/dashboard");
    } catch (error) {
      console.error("Error de autenticación:", error);
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
              <CardTitle className="text-2xl text-center text-white">Iniciar Sesión</CardTitle>
              <CardDescription className="text-center text-slate-300">
                Ingresa tus credenciales para acceder al sistema
              </CardDescription>
            </CardHeader>
            <form onSubmit={handleSubmit(onSubmit)}>
              <CardContent className="space-y-4">
                <div className="space-y-2">
                  <Label htmlFor="email" className="text-white">
                    Correo Electrónico
                  </Label>
                  <Input
                    id="email"
                    type="email"
                    placeholder="nombre@empresa.com"
                    className={`bg-slate-800/50 border-slate-700 text-white placeholder:text-slate-400 ${errors.email ? "border-red-500 focus-visible:ring-red-500" : ""}`}
                    {...register("email")}
                  />
                  {errors.email && (
                    <p className="text-red-500 text-sm mt-1">{errors.email.message}</p>
                  )}
                </div>
                <div className="space-y-2">
                  <div className="flex items-center justify-between">
                    <Label htmlFor="password" className="text-white">
                      Contraseña
                    </Label>
                    <Link
                      to="/recuperar-contrasena"
                      className="text-sm text-sky-400 hover:text-sky-300"
                    >
                      ¿Olvidaste tu contraseña?
                    </Link>
                  </div>
                  <Input
                    id="password"
                    type="password"
                    className={`bg-slate-800/50 border-slate-700 text-white ${errors.password ? "border-red-500 focus-visible:ring-red-500" : ""}`}
                    {...register("password")}
                  />
                  {errors.password && (
                    <p className="text-red-500 text-sm mt-1">{errors.password.message}</p>
                  )}
                </div>
                <div className="flex items-center space-x-2">
                  <Checkbox id="rememberMe" {...register("rememberMe")} />
                  <label
                    htmlFor="rememberMe"
                    className="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-slate-300"
                  >
                    Recordarme
                  </label>
                </div>
              </CardContent>
              <CardFooter className="flex flex-col gap-4">
                <Button
                  type="submit"
                  className="w-full bg-sky-600 hover:bg-sky-700"
                  size="lg"
                  disabled={loading}
                >
                  {loading ? "Iniciando sesión..." : "Iniciar Sesión"}
                </Button>
                <p className="text-sm text-center text-slate-400">
                  ¿No tienes una cuenta?{" "}
                  <Link to="/register" className="text-sky-400 hover:text-sky-300 font-medium">
                    Registrarse
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

export default Login;
