import { zodResolver } from "@hookform/resolvers/zod";
import { useRouter, useSearch } from "@tanstack/react-router";
import { Search, X } from "lucide-react";
import { useForm } from "react-hook-form";
import { z } from "zod";

import { Button } from "../../shared/components/ui/button";
import { Form, FormControl, FormField, FormItem } from "../../shared/components/ui/form";
import { Input } from "../../shared/components/ui/input";

const searchSchema = z.object({
  name: z.string().optional(),
});

type SearchFormValues = z.infer<typeof searchSchema>;

interface CompanySearchFormProps {
  companyId: string;
  onClose: () => void;
}

export function CompanySearchForm({ companyId, onClose }: CompanySearchFormProps) {
  const router = useRouter();
  // Tipado para el objeto de búsqueda
  type SearchParams = {
    name?: string;
  };
  
  const search = useSearch({ from: "/$companyId/companies/list" }) as SearchParams;
  
  const form = useForm<SearchFormValues>({
    resolver: zodResolver(searchSchema),
    defaultValues: {
      name: search.name || "",
    },
  });

  const onSubmit = (data: SearchFormValues) => {
    router.navigate({
      to: "/$companyId/companies/list",
      params: { companyId },
      search: data.name ? { name: data.name } : undefined,
    });
    onClose();
  };

  const handleCancel = () => {
    form.reset();
    if (search.name) {
      router.navigate({
        to: "/$companyId/companies/list",
        params: { companyId },
        search: {},
      });
    }
    onClose();
  };

  return (
    <div className="bg-card p-4 rounded-md shadow-md mb-4">
      <Form {...form}>
        <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-4">
          <div className="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">
            <FormField
              control={form.control}
              name="name"
              render={({ field }) => (
                <FormItem className="flex-1">
                  <FormControl>
                    <div className="relative">
                      <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                      <Input
                        placeholder="Buscar por nombre de compañía"
                        className="pl-10 w-full"
                        {...field}
                      />
                    </div>
                  </FormControl>
                </FormItem>
              )}
            />
            <div className="flex space-x-2">
              <Button type="submit" variant="default">
                Buscar
              </Button>
              <Button type="button" variant="outline" onClick={handleCancel}>
                <X className="h-4 w-4 mr-2" />
                Cancelar
              </Button>
            </div>
          </div>
        </form>
      </Form>
    </div>
  );
}
