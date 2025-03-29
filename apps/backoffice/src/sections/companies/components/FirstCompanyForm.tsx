import React from 'react';
import { useNavigate } from '@tanstack/react-router';
import { Form, FormField } from '../../shared/components/form';
import { z } from 'zod';

// Esquema para validación del formulario de primera empresa
const firstCompanySchema = z.object({
  companyName: z
    .string()
    .min(3, { message: "El nombre de la empresa debe tener al menos 3 caracteres" })
    .max(100, { message: "El nombre de la empresa no puede exceder los 100 caracteres" }),
  taxId: z
    .string()
    .min(1, { message: "El RIF es requerido" })
    .regex(/^[JGVE]-\d{8}-\d$/, { message: "Formato de RIF inválido (ej: J-12345678-9)" }),
  address: z
    .string()
    .min(5, { message: "La dirección debe tener al menos 5 caracteres" }),
  email: z
    .string()
    .email({ message: "Correo electrónico inválido" }),
  phone: z
    .string()
    .min(7, { message: "El teléfono debe tener al menos 7 caracteres" })
});

type FirstCompanyFormValues = z.infer<typeof firstCompanySchema>;

interface FirstCompanyFormProps {
  onSuccess?: (companyId: string) => void;
}

export function FirstCompanyForm({ onSuccess }: FirstCompanyFormProps) {
  const navigate = useNavigate();
  const [isLoading, setIsLoading] = React.useState(false);
  const [error, setError] = React.useState<string | null>(null);

  const handleSubmit = async (values: FirstCompanyFormValues) => {
    try {
      setIsLoading(true);
      setError(null);
      
      // Simulación de creación de empresa - en producción llamaría a la API
      console.log('Datos de empresa a crear:', values);
      
      // Simulamos un tiempo de espera y una respuesta exitosa
      setTimeout(() => {
        const newCompanyId = 'new-company-' + Date.now();
        setIsLoading(false);
        
        if (onSuccess) {
          onSuccess(newCompanyId);
        } else {
          navigate({ to: '/$companyId/dashboard', params: { companyId: newCompanyId } });
        }
      }, 1500);
    } catch (err) {
      setIsLoading(false);
      setError('Error al crear la empresa. Inténtelo de nuevo.');
    }
  };

  return (
    <div className="space-y-6 w-full max-w-lg">
      <div className="space-y-2 text-center">
        <h1 className="text-3xl font-bold">Registrar Empresa</h1>
        <p className="text-gray-500">
          Complete la información de su empresa
        </p>
      </div>
      
      {error && (
        <div className="bg-destructive/15 p-3 rounded-md text-destructive text-sm">
          {error}
        </div>
      )}
      
      <Form 
        schema={firstCompanySchema} 
        onSubmit={handleSubmit}
        defaultValues={{
          companyName: '',
          taxId: '',
          address: '',
          email: '',
          phone: ''
        }}
      >
        <div className="space-y-4">
          <FormField
            name="companyName"
            label="Nombre de la empresa"
            placeholder="Ingrese el nombre de su empresa"
          />
          
          <FormField
            name="taxId"
            label="RIF"
            placeholder="J-12345678-9"
          />
          
          <FormField
            name="address"
            label="Dirección"
            placeholder="Dirección completa de la empresa"
          />
          
          <FormField
            name="email"
            label="Correo electrónico"
            type="email"
            placeholder="contacto@empresa.com"
          />
          
          <FormField
            name="phone"
            label="Teléfono"
            placeholder="+58 212 1234567"
          />
        </div>
        
        <button
          type="submit"
          disabled={isLoading}
          className="mt-6 w-full rounded-md bg-primary py-2.5 font-medium text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
        >
          {isLoading ? 'Creando empresa...' : 'Crear empresa'}
        </button>
      </Form>
    </div>
  );
}
