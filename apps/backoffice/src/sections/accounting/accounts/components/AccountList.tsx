import { useNavigate } from "@tanstack/react-router";
import React from "react";

import { DataTable } from "../../../shared/components/data-table";

interface Account {
  id: string;
  code: string;
  name: string;
  type: "asset" | "liability" | "equity" | "income" | "expense";
  balance: number;
  isActive: boolean;
}

interface CellProps {
  row: {
    original: Account;
  };
}

export function AccountList() {
  const navigate = useNavigate();
  const [accounts, setAccounts] = React.useState<Account[]>([]);
  const [isLoading, setIsLoading] = React.useState(true);

  React.useEffect(() => {
    // Simulación de carga de datos
    const loadAccounts = async () => {
      try {
        // Aquí iría la llamada a la API real
        // Datos de ejemplo
        const data: Account[] = [
          {
            id: "1",
            code: "1.1.01",
            name: "Caja Principal",
            type: "asset",
            balance: 15000.0,
            isActive: true,
          },
          {
            id: "2",
            code: "1.1.02",
            name: "Banco Nacional Cuenta Corriente",
            type: "asset",
            balance: 25680.45,
            isActive: true,
          },
          {
            id: "3",
            code: "2.1.01",
            name: "Proveedores Nacionales",
            type: "liability",
            balance: 8750.2,
            isActive: true,
          },
          {
            id: "4",
            code: "4.1.01",
            name: "Ventas de Mercancía",
            type: "income",
            balance: 32450.75,
            isActive: true,
          },
        ];

        setTimeout(() => {
          setAccounts(data);
          setIsLoading(false);
        }, 1000);
      } catch (error) {
        setIsLoading(false);
        console.error("Error al cargar cuentas contables:", error);
      }
    };

    void loadAccounts();
  }, []);

  // Función para obtener el nombre del tipo de cuenta en español
  const getAccountTypeName = (type: Account["type"]) => {
    const types = {
      asset: "Activo",
      liability: "Pasivo",
      equity: "Patrimonio",
      income: "Ingreso",
      expense: "Gasto",
    };

    return types[type];
  };

  // Función para formatear montos
  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("es-VE", {
      style: "currency",
      currency: "VES",
    }).format(amount);
  };

  const columns = [
    {
      accessorKey: "code",
      header: "Código",
    },
    {
      accessorKey: "name",
      header: "Nombre",
    },
    {
      accessorKey: "type",
      header: "Tipo",
      cell: ({ row }: CellProps) => getAccountTypeName(row.original.type),
    },
    {
      accessorKey: "balance",
      header: "Saldo",
      cell: ({ row }: CellProps) => formatCurrency(row.original.balance),
    },
    {
      accessorKey: "isActive",
      header: "Estado",
      cell: ({ row }: CellProps) => (
        <span
          className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
            row.original.isActive ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800"
          }`}
        >
          {row.original.isActive ? "Activa" : "Inactiva"}
        </span>
      ),
    },
    {
      id: "actions",
      header: "Acciones",
      cell: ({ row }: CellProps) => (
        <div className="flex items-center space-x-2">
          <button
            className="text-blue-600 hover:text-blue-800"
            onClick={() => navigate({ to: `/accounting/accounts/${row.original.id}` })}
          >
            Ver
          </button>
          <button
            className="text-orange-600 hover:text-orange-800"
            onClick={() => navigate({ to: `/accounting/accounts/${row.original.id}/edit` })}
          >
            Editar
          </button>
        </div>
      ),
    },
  ];

  if (isLoading) {
    return <div className="flex justify-center p-8">Cargando cuentas contables...</div>;
  }

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">Cuentas Contables</h2>
        <button
          className="bg-primary text-primary-foreground hover:bg-primary/90 px-4 py-2 rounded-md"
          onClick={() => {
            // Temporalmente redirigimos al dashboard mientras se configura la ruta correcta
            void navigate({ to: "/$companyId/dashboard", params: { companyId: "1" } });
          }}
        >
          Nueva Cuenta
        </button>
      </div>

      <DataTable columns={columns} data={accounts} />
    </div>
  );
}
