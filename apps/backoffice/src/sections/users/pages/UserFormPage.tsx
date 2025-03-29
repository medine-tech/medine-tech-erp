import { useNavigate, useRouterState } from "@tanstack/react-router";
import { zodResolver } from "@hookform/resolvers/zod";
import { Loader2 } from "lucide-react";
import { useCallback, useEffect, useRef, useState } from "react";
import { useForm } from "react-hook-form";
import { z } from "zod";

import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "../../shared/components/ui/form";
import { Input } from "../../shared/components/ui/input";
import { useToast } from "../../shared/hooks/useToast";
import { Breadcrumb } from "../../shared/components/ui/breadcrumb";
import { Button } from "../../shared/components/ui/button";
import { userService } from "../services/user";

// Esquema de validación para formulario de usuario
const userSchema = z.object({
  id: z.string().optional(),
  name: z.string().min(1, { message: "El nombre es requerido" }),
  email: z.string().email({ message: "El correo electrónico no es válido" }),
  password: z
    .string()
    .min(8, { message: "La contraseña debe tener al menos 8 caracteres" })
    .optional(),
});

type UserFormValues = z.infer<typeof userSchema>;

export function UserFormPage() {
  const navigate = useNavigate();
  const { toast } = useToast();
  const [isLoading, setIsLoading] = useState(false);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const hasLoadedUser = useRef(false);

  const routerState = useRouterState();
  const currentRoute = routerState.matches[routerState.matches.length - 1].routeId;
  // Verificamos específicamente si estamos en la ruta de edición
  const isEditMode = currentRoute.includes("/users/edit/");

  // Obtenemos los parámetros desde el objeto de estado del enrutador
  type RouteParams = {
    companyId?: string;
    id?: string;
  };

  const routeParams = routerState.matches.reduce<RouteParams>((params, match) => {
    return { ...params, ...match.params };
  }, {});

  // Extraemos los parámetros necesarios con valores por defecto
  const companyId = routeParams.companyId ?? "";
  const userId = isEditMode ? (routeParams.id ?? "") : "";

  // Inicializar formulario
  const form = useForm<UserFormValues>({
    resolver: zodResolver(userSchema),
    defaultValues: {
      id: "",
      name: "",
      email: "",
      password: "",
    },
  });

  // Cargar usuario para edición
  const loadUser = useCallback(async () => {
    if (!isEditMode || !userId) { return; }

    setIsLoading(true);
    try {
      const user = await userService.getUserById(companyId, userId);
      form.reset({
        id: user.id,
        name: user.name,
        email: user.email,
        // No incluimos la contraseña para editar
      });
    } catch (error) {
      const errorMessage =
        error instanceof Error ? error.message : "Error al cargar los datos del usuario";
      toast({
        title: "Error",
        description: errorMessage,
        variant: "destructive",
      });
    } finally {
      setIsLoading(false);
    }
  }, [isEditMode, userId, form, toast]);

  // Ejecutamos loadUser solo una vez cuando tenemos los valores necesarios
  useEffect(() => {
    if (isEditMode && userId && !hasLoadedUser.current) {
      hasLoadedUser.current = true;
      loadUser();
    }
  }, [isEditMode, userId, loadUser]);

  // Manejar envío del formulario
  const onSubmit = async (data: UserFormValues) => {
    setIsSubmitting(true);
    
    try {
      if (isEditMode) {
        // Actualizar usuario existente
        await userService.updateUser(companyId, userId, {
          name: data.name,
        });
        toast({
          title: "Éxito",
          description: "Usuario actualizado correctamente",
        });
      } else {
        // Crear nuevo usuario
        if (!data.password) {
          throw new Error("La contraseña es requerida para crear un usuario");
        }
        await userService.createUser(companyId, {
          name: data.name,
          email: data.email,
          password: data.password,
        });
        toast({
          title: "Éxito",
          description: "Usuario creado correctamente",
        });
      }

      // Redirigir a la lista de usuarios
      void navigate({ to: "/$companyId/users/list", params: { companyId } });
    } catch (error) {
      const errorMessage =
        error instanceof Error
          ? error.message
          : isEditMode
          ? "Error al actualizar el usuario"
          : "Error al crear el usuario";
      toast({
        title: "Error",
        description: errorMessage,
        variant: "destructive",
      });
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <>
      <div className="mb-6">
        <Breadcrumb
          segments={[
            { label: "Usuarios", href: "/$companyId/users/list" },
            { label: isEditMode ? "Editar Usuario" : "Crear Usuario" },
          ]}
        />
      </div>

      <div className="flex justify-between items-center mb-6">
        <h2 className="text-2xl font-bold">{isEditMode ? "Editar Usuario" : "Crear Usuario"}</h2>
      </div>

      <div className="bg-card shadow-md rounded-lg p-6 max-w-2xl mx-auto">
        {isLoading ? (
          <div className="flex justify-center items-center py-8">
            <Loader2 className="h-8 w-8 animate-spin text-primary" />
            <span className="ml-2 text-muted-foreground">Cargando datos del usuario...</span>
          </div>
        ) : (
          <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
              <input type="hidden" {...form.register("id")} />

              <FormField
                control={form.control}
                name="name"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Nombre</FormLabel>
                    <FormControl>
                      <Input placeholder="Nombre del usuario" {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

              <FormField
                control={form.control}
                name="email"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Correo electrónico</FormLabel>
                    <FormControl>
                      <Input type="email" placeholder="correo@ejemplo.com" {...field} disabled={isEditMode} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

              {!isEditMode && (
                <FormField
                  control={form.control}
                  name="password"
                  render={({ field }) => (
                    <FormItem>
                      <FormLabel>Contraseña</FormLabel>
                      <FormControl>
                        <Input type="password" placeholder="********" {...field} />
                      </FormControl>
                      <FormMessage />
                    </FormItem>
                  )}
                />
              )}

              <div className="flex justify-end gap-4">
                <Button
                  type="button"
                  variant="outline"
                  onClick={() => void navigate({ to: "/$companyId/users/list", params: { companyId } })}
                >
                  Cancelar
                </Button>
                <Button type="submit" disabled={isSubmitting || isLoading}>
                  {isLoading ? "Cargando..." : isSubmitting ? "Guardando..." : "Guardar"}
                </Button>
              </div>
            </form>
          </Form>
        )}
      </div>
    </>
  );
}
