import { useNavigate } from "@tanstack/react-router";
import React from "react";

import { Form, FormField } from "../../shared/components/form";
import { useAuth } from "../context/AuthContext";
import { firstCompanySchema } from "../lib/validations";
import { authService } from "../services";

interface RegisterFormProps {
  onSuccess?: () => void;
}

export function RegisterForm({ onSuccess }: RegisterFormProps) {
  const navigate = useNavigate();
  const { login, error: authError, clearError } = useAuth();
  const [isLoading, setIsLoading] = React.useState(false);
  const [error, setError] = React.useState<string | null>(null);

  const handleSubmit = async (values: {
    companyName: string;
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
  }) => {
    try {
      setIsLoading(true);
      setError(null);
      clearError();

      const companyId = crypto.randomUUID();

      await authService.register({
        companyId,
        companyName: values.companyName,
        name: values.name,
        email: values.email,
        password: values.password,
        password_confirmation: values.password_confirmation,
      });

      // Iniciar sesión automáticamente después del registro
      const defaultCompanyId = await login(values.email, values.password);

      setIsLoading(false);

      if (onSuccess) {
        onSuccess();
      } else {
        // Redirigir al dashboard usando el ID de compañía devuelto por la API
        void navigate({ to: "/$companyId/dashboard", params: { companyId: defaultCompanyId } });
      }
    } catch (_err) {
      setIsLoading(false);
      setError("Error al registrar el usuario. Inténtelo de nuevo.");
    }
  };

  return (
    <div className="space-y-6 w-full max-w-md">
      <div className="space-y-2 text-center">
        <h1 className="text-3xl font-bold">Crear cuenta</h1>
        <p className="text-gray-500">Ingrese sus datos para registrarse</p>
      </div>

      {(error ?? authError) && (
        <div className="bg-destructive/15 p-3 rounded-md text-destructive text-sm">
          {error ?? (authError && authError.detail)}
        </div>
      )}

      <Form
        schema={firstCompanySchema}
        onSubmit={handleSubmit}
        defaultValues={{
          companyId: crypto.randomUUID(),
          companyName: "",
          name: "",
          email: "",
          password: "",
          password_confirmation: "",
        }}
      >
        <FormField
          name="companyName"
          label="Nombre de la Empresa"
          placeholder="Ingrese el nombre de su empresa"
        />

        <FormField name="name" label="Nombre completo" placeholder="Ingrese su nombre completo" />

        <FormField
          name="email"
          label="Correo electrónico"
          type="email"
          placeholder="correo@ejemplo.com"
        />

        <FormField
          name="password"
          label="Contraseña"
          type="password"
          placeholder="********"
          description="La contraseña debe tener al menos 8 caracteres"
        />

        <FormField
          name="password_confirmation"
          label="Confirmar contraseña"
          type="password"
          placeholder="********"
        />

        <button
          type="submit"
          disabled={isLoading}
          className="mt-6 w-full rounded-md bg-primary py-2.5 font-medium text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
        >
          {isLoading ? "Registrando..." : "Registrarse"}
        </button>
      </Form>

      <div className="text-center text-sm">
        ¿Ya tiene una cuenta?{" "}
        <a href="/login" className="text-primary hover:underline">
          Iniciar sesión
        </a>
      </div>
    </div>
  );
}
