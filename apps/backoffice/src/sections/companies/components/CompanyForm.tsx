import { useNavigate } from "@tanstack/react-router";
import React from "react";
import { z } from "zod";

import { Form, FormField } from "../../shared/components/form";

const companySchema = z.object({
  name: z.string().min(3, "El nombre debe tener al menos 3 caracteres"),
  taxId: z.string().min(10, "El RIF debe tener un formato válido (ej: J-12345678-9)"),
  address: z.string().min(5, "La dirección es requerida"),
  email: z.string().email("Ingrese un correo electrónico válido"),
  phone: z.string().min(7, "Ingrese un número de teléfono válido"),
  status: z.enum(["active", "inactive"]),
});

type CompanyFormValues = z.infer<typeof companySchema>;

interface CompanyFormProps {
  initialData?: Partial<CompanyFormValues>;
  isEditMode?: boolean;
  onSuccess?: () => void;
}

export function CompanyForm({ initialData, isEditMode = false, onSuccess }: CompanyFormProps) {
  const navigate = useNavigate();
  const [isLoading, setIsLoading] = React.useState(false);
  const [error, setError] = React.useState<string | null>(null);

  const defaultValues: Partial<CompanyFormValues> = {
    name: "",
    taxId: "",
    address: "",
    email: "",
    phone: "",
    status: "active",
    ...initialData,
  };

  const handleSubmit = async (_values: CompanyFormValues) => {
    try {
      setIsLoading(true);
      setError(null);

      // Aquí iría la llamada a la API para crear/actualizar la empresa

      // Simulación de guardado exitoso
      setTimeout(() => {
        setIsLoading(false);
        if (onSuccess) {
          onSuccess();
        } else {
          // Temporalmente redirigimos al dashboard mientras se configura la ruta de empresas
          void navigate({ to: "/$companyId/dashboard", params: { companyId: "1" } });
        }
      }, 1000);
    } catch (_err) {
      setIsLoading(false);
      setError("Error al guardar la empresa. Inténtelo de nuevo.");
    }
  };

  return (
    <div className="space-y-6 max-w-2xl mx-auto">
      <div className="space-y-2">
        <h1 className="text-2xl font-bold">
          {isEditMode ? "Editar Empresa" : "Crear Nueva Empresa"}
        </h1>
        <p className="text-gray-500">Complete la información de la empresa</p>
      </div>

      {error && (
        <div className="bg-destructive/15 p-3 rounded-md text-destructive text-sm">{error}</div>
      )}

      <Form schema={companySchema} onSubmit={handleSubmit} defaultValues={defaultValues}>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <FormField
            name="name"
            label="Nombre de la empresa"
            placeholder="Ingrese el nombre de la empresa"
          />

          <FormField name="taxId" label="RIF" placeholder="J-12345678-9" />

          <FormField
            name="email"
            label="Correo electrónico"
            type="email"
            placeholder="contacto@empresa.com"
          />

          <FormField name="phone" label="Teléfono" placeholder="+58 212 1234567" />

          <div className="md:col-span-2">
            <FormField
              name="address"
              label="Dirección"
              placeholder="Dirección completa de la empresa"
            />
          </div>

          <div>
            <label className="text-sm font-medium leading-none mb-2 block">Estado</label>
            <div className="flex items-center space-x-4">
              <FormField name="status" label="">
                <select
                  className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background
                                   file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground
                                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
                                   disabled:cursor-not-allowed disabled:opacity-50"
                >
                  <option value="active">Activa</option>
                  <option value="inactive">Inactiva</option>
                </select>
              </FormField>
            </div>
          </div>
        </div>

        <div className="flex items-center justify-end space-x-4 mt-6">
          <button
            type="button"
            onClick={() => {
              void navigate({ to: "/$companyId/dashboard", params: { companyId: "1" } });
            }}
            className="rounded-md border px-4 py-2 text-sm font-medium bg-background"
          >
            Cancelar
          </button>
          <button
            type="submit"
            disabled={isLoading}
            className="rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
          >
            {isLoading ? "Guardando..." : isEditMode ? "Actualizar" : "Crear"}
          </button>
        </div>
      </Form>
    </div>
  );
}
