import { useNavigate, useSearch } from "@tanstack/react-router";
import { zodResolver } from "@hookform/resolvers/zod";
import { Search } from "lucide-react";
import { useForm } from "react-hook-form";
import { z } from "zod";

import { Button } from "../../shared/components/ui/button";
import { Form, FormControl, FormField, FormItem } from "../../shared/components/ui/form";
import { Input } from "../../shared/components/ui/input";

const searchSchema = z.object({
  name: z.string().optional(),
});

type SearchFormValues = z.infer<typeof searchSchema>;

interface UserSearchFormProps {
  companyId: string;
  onClose: () => void;
}

export function UserSearchForm({ companyId, onClose }: UserSearchFormProps) {
  const navigate = useNavigate();

  type SearchParams = {
    name?: string;
  };

  const search = useSearch({ from: "/$companyId/users/list" }) as SearchParams;

  const form = useForm<SearchFormValues>({
    resolver: zodResolver(searchSchema),
    defaultValues: {
      name: search.name ?? "",
    },
  });

  const onSubmit = (data: SearchFormValues) => {
    void navigate({
      to: "/$companyId/users/list",
      params: { companyId },
      search: data.name ? { name: data.name } : undefined,
    });
  };

  const handleCancel = () => {
    form.reset();
    if (search.name) {
      void navigate({
        to: "/$companyId/users/list",
        params: { companyId },
        search: {},
      });
    }
    onClose();
  };

  return (
    <div className="mb-6 p-4 bg-card/50 border border-border/40 shadow-sm rounded-lg">
      <Form {...form}>
        <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-4">
          <div className="flex flex-col md:flex-row gap-4">
            <FormField
              control={form.control}
              name="name"
              render={({ field }) => (
                <FormItem className="flex-1">
                  <FormControl>
                    <div className="relative">
                      <Search className="absolute left-2 top-2.5 h-4 w-4 text-muted-foreground" />
                      <Input placeholder="Buscar por nombre" className="pl-8" {...field} />
                    </div>
                  </FormControl>
                </FormItem>
              )}
            />
            <div className="flex gap-2">
              <Button type="submit" className="min-w-[100px]">
                Buscar
              </Button>
              <Button type="button" variant="outline" onClick={handleCancel}>
                Cancelar
              </Button>
            </div>
          </div>
        </form>
      </Form>
    </div>
  );
}
