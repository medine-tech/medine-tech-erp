import { Link } from "@tanstack/react-router";
import { useEffect, useState } from "react";

import { ApiError } from "../../auth/services/auth";
import { Button } from "../../shared/components/ui/button";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "../../shared/components/ui/table";
import { Company, companyService } from "../services/company";

interface CompaniesTableProps {
  companyId: string;
  currentPage: number;
  perPage: number;
  onPageChange: (page: number) => void;
  onPerPageChange: (perPage: number) => void;
}

export function CompaniesTable({
  companyId,
  currentPage,
  perPage,
  onPageChange,
  onPerPageChange: _onPerPageChange,
}: CompaniesTableProps) {
  const [companies, setCompanies] = useState<Company[]>([]);
  const [pagination, setPagination] = useState<{
    total: number;
    currentPage: number;
    perPage: number;
  }>({
    total: 0,
    currentPage: 1,
    perPage: 10,
  });
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<ApiError | null>(null);

  useEffect(() => {
    let isMounted = true;

    async function fetchCompanies() {
      if (isLoading) {
        return;
      }

      setIsLoading(true);
      setError(null);

      try {
        const response = await companyService.getCompanies(companyId, currentPage, perPage);

        if (isMounted) {
          setCompanies(response.items);
          setPagination({
            total: response.total,
            currentPage: response.current_page,
            perPage: response.per_page,
          });
          setIsLoading(false);
        }
      } catch (err) {
        if (isMounted) {
          setError(err as ApiError);
          setIsLoading(false);
        }
      }
    }

    void fetchCompanies();

    return () => {
      isMounted = false;
    };
  }, [currentPage, perPage, companyId, isLoading]);

  const handlePageChange = (page: number) => {
    onPageChange(page);
  };

  if (error) {
    return (
      <div className="bg-destructive/15 p-4 rounded-md text-destructive">
        <h3 className="font-semibold text-lg">Error</h3>
        <p>{error.detail || "Ha ocurrido un error al cargar las compañías."}</p>
      </div>
    );
  }

  return (
    <div className="space-y-4">
      <div className="rounded-md border">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>ID</TableHead>
              <TableHead>Nombre</TableHead>
              <TableHead>Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {isLoading ? (
              <TableRow>
                <TableCell colSpan={3} className="h-24 text-center">
                  <div className="flex justify-center items-center h-full">
                    <svg
                      className="animate-spin h-5 w-5 text-primary"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                    >
                      <circle
                        className="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        strokeWidth="4"
                      ></circle>
                      <path
                        className="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                      ></path>
                    </svg>
                    <span className="ml-2">Cargando...</span>
                  </div>
                </TableCell>
              </TableRow>
            ) : companies.length > 0 ? (
              companies.map((company: Company) => (
                <TableRow key={company.id}>
                  <TableCell className="w-32 truncate">{company.id}</TableCell>
                  <TableCell className="font-medium">{company.name}</TableCell>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      <Link
                        to="/$companyId/companies/edit/$id"
                        params={{ companyId, id: company.id }}
                      >
                        <Button variant="outline" size="sm">
                          Ver
                        </Button>
                      </Link>
                      <Link
                        to="/$companyId/companies/edit/$id"
                        params={{ companyId, id: company.id }}
                      >
                        <Button variant="outline" size="sm">
                          Editar
                        </Button>
                      </Link>
                    </div>
                  </TableCell>
                </TableRow>
              ))
            ) : (
              <TableRow>
                <TableCell colSpan={3} className="h-24 text-center">
                  No se encontraron resultados.
                </TableCell>
              </TableRow>
            )}
          </TableBody>
        </Table>
      </div>

      <div className="flex items-center justify-between space-x-2 py-4">
        <div className="text-sm text-muted-foreground">
          Mostrando {companies.length} de {pagination.total} compañías
        </div>

        <div className="flex items-center space-x-2">
          <Button
            variant="outline"
            size="sm"
            onClick={() => handlePageChange(1)}
            disabled={pagination.currentPage <= 1}
          >
            Primera
          </Button>
          <Button
            variant="outline"
            size="sm"
            onClick={() => handlePageChange(pagination.currentPage - 1)}
            disabled={pagination.currentPage <= 1}
          >
            Anterior
          </Button>
          <span className="flex items-center gap-1">
            <div>Página</div>
            <strong>
              {pagination.currentPage} de {Math.ceil(pagination.total / pagination.perPage) || 1}
            </strong>
          </span>
          <Button
            variant="outline"
            size="sm"
            onClick={() => handlePageChange(pagination.currentPage + 1)}
            disabled={pagination.currentPage >= Math.ceil(pagination.total / pagination.perPage)}
          >
            Siguiente
          </Button>
          <Button
            variant="outline"
            size="sm"
            onClick={() => handlePageChange(Math.ceil(pagination.total / pagination.perPage))}
            disabled={pagination.currentPage >= Math.ceil(pagination.total / pagination.perPage)}
          >
            Última
          </Button>
        </div>
      </div>
    </div>
  );
}
