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
  name: z.string().min(3, "El nombre debe tener al menos 3 caracteres"),
  tax_id: z.string().min(5, "El RIF/NIT debe tener al menos 5 caracteres"),
  email: z.string().email("Ingrese un correo electrónico válido"),
  phone: z.string().min(10, "El teléfono debe tener al menos 10 caracteres"),
  address: z.string().min(5, "La dirección debe tener al menos 5 caracteres"),
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
      name: "",
      tax_id: "",
      email: "",
      phone: "",
      address: "",
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
              <FormField
                control={form.control}
                name="name"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Nombre</FormLabel>
                    <FormControl>
                      <Input placeholder="Nombre de la compañía" {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

              <FormField
                control={form.control}
                name="tax_id"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>RIF/NIT</FormLabel>
                    <FormControl>
                      <Input placeholder="RIF o NIT de la compañía" {...field} />
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
                    <FormLabel>Correo Electrónico</FormLabel>
                    <FormControl>
                      <Input placeholder="correo@ejemplo.com" type="email" {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

              <FormField
                control={form.control}
                name="phone"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Teléfono</FormLabel>
                    <FormControl>
                      <Input placeholder="+58 412 1234567" {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

              <FormField
                control={form.control}
                name="address"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Dirección</FormLabel>
                    <FormControl>
                      <Input placeholder="Dirección de la compañía" {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

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
