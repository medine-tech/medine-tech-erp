import { useNavigate } from "@tanstack/react-router";
import React from "react";

import { Form, FormField } from "../../shared/components/form";
import { useAuth } from "../context/AuthContext";
import { authService } from "../services";
import { registerSchema } from "../lib/validations";

interface RegisterFormProps {
  onSuccess?: () => void;
}

export function RegisterForm({ onSuccess }: RegisterFormProps) {
  const navigate = useNavigate();
  const { login, error: authError, clearError } = useAuth();
  const [isLoading, setIsLoading] = React.useState(false);
  const [error, setError] = React.useState<string | null>(null);

  const handleSubmit = async (values: {
    name: string;
    email: string;
    password: string;
    confirmPassword: string;
  }) => {
    try {
      setIsLoading(true);
      setError(null);
      clearError();

      // Llamada a la API para registrar al usuario
      await authService.register({
        name: values.name,
        email: values.email,
        password: values.password,
      });

      // Iniciar sesión automáticamente después del registro
      await login(values.email, values.password);

      setIsLoading(false);

      if (onSuccess) {
        onSuccess();
      } else {
        void navigate({ to: "/login" });
      }
    } catch (err) {
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

      {(error || authError) && (
        <div className="bg-destructive/15 p-3 rounded-md text-destructive text-sm">
          {error || (authError && authError.detail)}
        </div>
      )}

      <Form
        schema={registerSchema}
        onSubmit={handleSubmit}
        defaultValues={{
          name: "",
          email: "",
          password: "",
          confirmPassword: "",
        }}
      >
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
          name="confirmPassword"
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
