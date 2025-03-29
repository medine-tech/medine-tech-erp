import { zodResolver } from "@hookform/resolvers/zod";
import { useNavigate, useParams, useRouterState } from "@tanstack/react-router";
import { useEffect, useState } from "react";
import { ControllerRenderProps, useForm } from "react-hook-form";
import { z } from "zod";

import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "../../../sections/shared/components/ui/form";
import { Input } from "../../../sections/shared/components/ui/input";
import { useToast } from "../../../sections/shared/hooks/useToast";
import { UserProfile } from "../../auth/components/UserProfile";
import { Breadcrumb } from "../../shared/components/ui/breadcrumb";
import { Button } from "../../shared/components/ui/button";
import { companyService } from "../services/company";

const companySchema = z.object({
  id: z.string().uuid("El ID debe ser un UUID válido"),
  name: z.string().min(3, "El nombre debe tener al menos 3 caracteres"),
});

type CompanyFormValues = z.infer<typeof companySchema>;

function CompanyFormPageComponent() {
  // Obtener el companyId y el id de la compañía a editar si existe
  const routerState = useRouterState();
  const routePath = routerState.matches[routerState.matches.length - 1].routeId;
  const isEditMode = routePath.includes("/edit/$id");

  // Obtenemos los parámetros de forma no condicional
  const editParams = useParams({ from: "/$companyId/companies/edit/$id" });
  const createParams = useParams({ from: "/$companyId/companies/create" });

  // Después de llamar a los hooks, usamos lógica condicional
  const companyId = isEditMode
    ? (editParams.companyId as string)
    : (createParams.companyId as string);

  const companyIdToEdit = isEditMode ? (editParams.id as string) : "";

  const navigate = useNavigate();
  const { toast } = useToast();
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [isLoading, setIsLoading] = useState(false);

  const form = useForm<CompanyFormValues>({
    resolver: zodResolver(companySchema),
    defaultValues: {
      id: crypto.randomUUID(), // Generar un UUID por defecto
      name: "",
    },
  });

  // Cargar datos de la compañía si estamos en modo edición
  useEffect(() => {
    // Flag para evitar que se ejecute más de una vez
    let isMounted = true;

    if (isEditMode && companyIdToEdit) {
      const fetchCompanyDetails = async () => {
        // Evitamos llamadas repetidas
        if (isLoading) {
          return;
        }

        setIsLoading(true);
        try {
          const company = await companyService.getCompany(companyId, companyIdToEdit);

          // Solo actualizamos los valores si el componente sigue montado
          if (isMounted) {
            form.setValue("id", company.id);
            form.setValue("name", company.name);
          }
        } catch (_error) {
          if (isMounted) {
            toast({
              title: "Error",
              description: "No se pudo cargar la información de la compañía",
              variant: "destructive",
            });
          }
        } finally {
          if (isMounted) {
            setIsLoading(false);
          }
        }
      };

      void fetchCompanyDetails();
    }

    // Cleanup function para evitar actualizaciones si el componente se desmonta
    return () => {
      isMounted = false;
    };
  }, []); // Eliminamos todas las dependencias para que solo se ejecute al montar

  async function onSubmit(data: CompanyFormValues) {
    setIsSubmitting(true);
    try {
      if (isEditMode && companyIdToEdit) {
        // Actualizar compañía existente
        await companyService.updateCompany(companyId, companyIdToEdit, { name: data.name });
        toast({
          title: "Éxito",
          description: "Compañía actualizada correctamente",
        });
      } else {
        // Crear nueva compañía
        await companyService.createCompany(companyId, data);
        toast({
          title: "Éxito",
          description: "Compañía creada correctamente",
        });
      }
      void navigate({ to: "/$companyId/companies/list", params: { companyId } });
    } catch (_error) {
      toast({
        title: "Error",
        description: isEditMode
          ? "Ha ocurrido un error al actualizar la compañía"
          : "Ha ocurrido un error al crear la compañía",
        variant: "destructive",
      });
    } finally {
      setIsSubmitting(false);
    }
  }

  return (
    <div className="min-h-screen bg-background">
      <header className="bg-card shadow-sm border-b">
        <div className="container mx-auto px-4 py-4 flex justify-between items-center">
          <div className="flex items-center">
            <h1 className="text-xl font-medium text-foreground mr-6">Medine Tech</h1>
          </div>
          <UserProfile />
        </div>
      </header>

      <div className="container mx-auto py-8 px-4">
        <div className="mb-6">
          <Breadcrumb
            segments={[
              { label: "Compañías", href: "/$companyId/companies/list" },
              { label: isEditMode ? "Editar Compañía" : "Crear Compañía" },
            ]}
          />
        </div>

        <div className="flex justify-between items-center mb-6">
          <h2 className="text-2xl font-bold">
            {isEditMode ? "Editar Compañía" : "Crear Compañía"}
          </h2>
        </div>

        <div className="bg-card shadow-md rounded-lg p-6 max-w-2xl mx-auto">
          <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
              {/* Campo ID oculto, autogenerado con crypto */}
              <input type="hidden" {...form.register("id")} />

              <FormField
                control={form.control}
                name="name"
                render={({
                  field,
                }: {
                  field: ControllerRenderProps<CompanyFormValues, "name">;
                }) => (
                  <FormItem>
                    <FormLabel>Nombre</FormLabel>
                    <FormControl>
                      <Input placeholder="Nombre de la compañía" {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

              {/* Solo se mantiene el campo de nombre como visible */}

              <div className="flex justify-end gap-4">
                <Button
                  type="button"
                  variant="outline"
                  onClick={() =>
                    navigate({ to: "/$companyId/companies/list", params: { companyId } })
                  }
                >
                  Cancelar
                </Button>
                <Button type="submit" disabled={isSubmitting || isLoading}>
                  {isLoading ? "Cargando..." : isSubmitting ? "Guardando..." : "Guardar"}
                </Button>
              </div>
            </form>
          </Form>
        </div>
      </div>
    </div>
  );
}

export { CompanyFormPageComponent as CompanyFormPage };
