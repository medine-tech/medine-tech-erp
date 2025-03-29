import { useNavigate } from "@tanstack/react-router";
import React from "react";

import { DataTable } from "../../shared/components/data-table";

interface Company {
  id: string;
  name: string;
  taxId: string;
  address: string;
  email: string;
  phone: string;
  status: "active" | "inactive";
}

export function CompanyList() {
  const navigate = useNavigate();
  const [companies, setCompanies] = React.useState<Company[]>([]);
  const [isLoading, setIsLoading] = React.useState(true);

  React.useEffect(() => {
    // Simular carga de datos
    const loadCompanies = async () => {
      try {
        // Aquí iría la llamada a la API real
        // Datos de ejemplo
        const data: Company[] = [
          {
            id: "1",
            name: "Empresa Demo 1",
            taxId: "J-12345678-9",
            address: "Av. Principal #123",
            email: "contacto@empresa1.com",
            phone: "+58 212 1234567",
            status: "active",
          },
          {
            id: "2",
            name: "Empresa Demo 2",
            taxId: "J-87654321-0",
            address: "Calle Secundaria #456",
            email: "contacto@empresa2.com",
            phone: "+58 212 7654321",
            status: "active",
          },
        ];

        setTimeout(() => {
          setCompanies(data);
          setIsLoading(false);
        }, 1000);
      } catch (error) {
        setIsLoading(false);
        console.error("Error al cargar empresas:", error);
      }
    };

    void loadCompanies();
  }, []);

  const columns = [
    {
      accessorKey: "name",
      header: "Nombre",
    },
    {
      accessorKey: "taxId",
      header: "RIF",
    },
    {
      accessorKey: "email",
      header: "Correo",
    },
    {
      accessorKey: "phone",
      header: "Teléfono",
    },
    {
      accessorKey: "status",
      header: "Estado",
      cell: ({ row }: any) => (
        <span
          className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
            row.original.status === "active"
              ? "bg-green-100 text-green-800"
              : "bg-red-100 text-red-800"
          }`}
        >
          {row.original.status === "active" ? "Activa" : "Inactiva"}
        </span>
      ),
    },
    {
      id: "actions",
      header: "Acciones",
      cell: ({ row }: any) => (
        <div className="flex items-center space-x-2">
          <button
            className="text-blue-600 hover:text-blue-800"
            onClick={() => navigate({ to: `/companies/${row.original.id}` })}
          >
            Ver
          </button>
          <button
            className="text-orange-600 hover:text-orange-800"
            onClick={() => navigate({ to: `/companies/${row.original.id}/edit` })}
          >
            Editar
          </button>
        </div>
      ),
    },
  ];

  if (isLoading) {
    return <div className="flex justify-center p-8">Cargando empresas...</div>;
  }

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">Empresas</h2>
        <button
          className="bg-primary text-primary-foreground hover:bg-primary/90 px-4 py-2 rounded-md"
          onClick={() => void navigate({ to: "/$companyId/dashboard", params: { companyId: "1" } })}
        >
          Crear Empresa
        </button>
      </div>

      <DataTable columns={columns} data={companies} />
    </div>
  );
}
