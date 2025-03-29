import React from 'react';
import { useNavigate } from '@tanstack/react-router';
import { Form, FormField } from '../../shared/components/form';
import { registerSchema } from '../lib/validations';
import { Checkbox } from '../../shared/components/ui/checkbox';

interface RegisterFormProps {
  onSuccess?: () => void;
}

export function RegisterForm({ onSuccess }: RegisterFormProps) {
  const navigate = useNavigate();
  const [isLoading, setIsLoading] = React.useState(false);
  const [error, setError] = React.useState<string | null>(null);

  const handleSubmit = async () => {
    try {
      setIsLoading(true);
      setError(null);
      
      // Simulación de registro - en producción llamaría a la API
      setTimeout(() => {
        setIsLoading(false);
        if (onSuccess) {
          onSuccess();
        } else {
          navigate({ to: '/login' });
        }
      }, 1500);
    } catch (err) {
      setIsLoading(false);
      setError('Error al registrar el usuario. Inténtelo de nuevo.');
    }
  };

  return (
    <div className="space-y-6 w-full max-w-md">
      <div className="space-y-2 text-center">
        <h1 className="text-3xl font-bold">Crear cuenta</h1>
        <p className="text-gray-500">
          Ingrese sus datos para registrarse
        </p>
      </div>
      
      {error && (
        <div className="bg-destructive/15 p-3 rounded-md text-destructive text-sm">
          {error}
        </div>
      )}
      
      <Form 
        schema={registerSchema} 
        onSubmit={handleSubmit}
        defaultValues={{
          name: '',
          email: '',
          password: '',
          confirmPassword: '',
          termsAccepted: false
        }}
      >
        <FormField
          name="name"
          label="Nombre completo"
          placeholder="Ingrese su nombre completo"
        />
        
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
        
        <div className="flex items-center space-x-2 mt-4">
          <FormField name="termsAccepted" label="">
            <Checkbox />
          </FormField>
          <label className="text-sm">
            Acepto los{' '}
            <a href="/terms" className="text-primary hover:underline">
              términos y condiciones
            </a>
          </label>
        </div>
        
        <button
          type="submit"
          disabled={isLoading}
          className="mt-6 w-full rounded-md bg-primary py-2.5 font-medium text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
        >
          {isLoading ? 'Registrando...' : 'Registrarse'}
        </button>
      </Form>
      
      <div className="text-center text-sm">
        ¿Ya tiene una cuenta?{' '}
        <a href="/login" className="text-primary hover:underline">
          Iniciar sesión
        </a>
      </div>
    </div>
  );
}
