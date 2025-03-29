import { useNavigate } from "@tanstack/react-router";
import React from "react";

import { Form, FormField } from "../../shared/components/form";
import { loginSchema } from "../lib/validations";

interface LoginFormProps {
  onSuccess?: () => void;
}

export function LoginForm({ onSuccess }: LoginFormProps) {
  const navigate = useNavigate();
  const [isLoading, setIsLoading] = React.useState(false);
  const [error, setError] = React.useState<string | null>(null);

  const handleSubmit = async () => {
    try {
      setIsLoading(true);
      setError(null);

      // Ejemplo de petición de login
      // Aquí iría la llamada a la API de autenticación
      // const response = await api.auth.login(values);

      // Simulación de login exitoso
      setTimeout(() => {
        setIsLoading(false);
        if (onSuccess) {
          onSuccess();
        } else {
          void navigate({ to: "/$companyId/dashboard", params: { companyId: "1" } });
        }
      }, 1000);
    } catch (_err) {
      setIsLoading(false);
      setError("Credenciales inválidas. Inténtelo de nuevo.");
    }
  };

  return (
    <div className="space-y-6 w-full max-w-md">
      <div className="space-y-2 text-center">
        <h1 className="text-3xl font-bold">Iniciar sesión</h1>
        <p className="text-gray-500">Ingrese sus credenciales para acceder a su cuenta</p>
      </div>

      {error && (
        <div className="bg-destructive/15 p-3 rounded-md text-destructive text-sm">{error}</div>
      )}

      <Form
        schema={loginSchema}
        onSubmit={handleSubmit}
        defaultValues={{ email: "", password: "" }}
      >
        <FormField
          name="email"
          label="Correo electrónico"
          type="email"
          placeholder="correo@ejemplo.com"
        />

        <FormField name="password" label="Contraseña" type="password" placeholder="********" />

        <div className="flex items-center justify-between mt-2">
          <div className="flex items-center space-x-2">
            <input type="checkbox" id="remember" className="h-4 w-4 rounded border-gray-300" />
            <label htmlFor="remember" className="text-sm">
              Recordarme
            </label>
          </div>

          <a href="/forgot-password" className="text-sm text-primary hover:underline">
            ¿Olvidó su contraseña?
          </a>
        </div>

        <button
          type="submit"
          disabled={isLoading}
          className="mt-4 w-full rounded-md bg-primary py-2.5 font-medium text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
        >
          {isLoading ? "Iniciando sesión..." : "Iniciar sesión"}
        </button>
      </Form>

      <div className="text-center text-sm">
        ¿No tiene una cuenta?{" "}
        <a href="/register" className="text-primary hover:underline">
          Registrarse
        </a>
      </div>
    </div>
  );
}
