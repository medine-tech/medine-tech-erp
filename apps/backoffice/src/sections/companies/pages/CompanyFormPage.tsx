import { useParams, useNavigate } from "@tanstack/react-router";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useState } from "react";

import { UserProfile } from "../../auth/components/UserProfile";
import { Breadcrumb } from "../../shared/components/ui/breadcrumb";
import { Button } from "../../shared/components/ui/button";
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
import { companyService } from "../services/company";

const companySchema = z.object({
  id: z.string().uuid("El ID debe ser un UUID válido"),
  name: z.string().min(3, "El nombre debe tener al menos 3 caracteres"),
});

type CompanyFormValues = z.infer<typeof companySchema>;

export function CompanyFormPage() {
  const { companyId } = useParams({ from: "/$companyId/companies/create" });
  const navigate = useNavigate({ from: "/$companyId/companies/create" });
  const { toast } = useToast();
  const [isSubmitting, setIsSubmitting] = useState(false);

  const form = useForm<CompanyFormValues>({
    resolver: zodResolver(companySchema),
    defaultValues: {
      id: crypto.randomUUID(), // Generar un UUID por defecto
      name: "",
    },
  });

  async function onSubmit(data: CompanyFormValues) {
    setIsSubmitting(true);
    try {
      await companyService.createCompany(companyId, data);
      toast({
        title: "Éxito",
        description: "Compañía creada correctamente",
      });
      navigate({ to: "/$companyId/companies/list", params: { companyId } });
    } catch (error) {
      toast({
        title: "Error",
        description: "Ha ocurrido un error al crear la compañía",
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
              { label: "Crear Compañía" },
            ]}
          />
        </div>

        <div className="flex justify-between items-center mb-6">
          <h2 className="text-2xl font-bold">Crear Compañía</h2>
        </div>
        
        <div className="bg-card shadow-md rounded-lg p-6 max-w-2xl mx-auto">
          <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
              {/* Campo ID oculto, autogenerado con crypto */}
              <input type="hidden" {...form.register("id")} />

              <FormField
                control={form.control}
                name="name"
                render={({ field }: { field: any }) => (
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
                  onClick={() => navigate({ to: "/$companyId/companies/list", params: { companyId } })}
                >
                  Cancelar
                </Button>
                <Button type="submit" disabled={isSubmitting}>
                  {isSubmitting ? "Guardando..." : "Guardar"}
                </Button>
              </div>
            </form>
          </Form>
        </div>
      </div>
    </div>
  );
}
