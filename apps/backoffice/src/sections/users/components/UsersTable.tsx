import { Link } from "@tanstack/react-router";
import {
  AlertCircle, ChevronLeftIcon, ChevronRightIcon, Edit2, Loader2 
} from "lucide-react";
import { useCallback, useEffect, useState } from "react";

import { Button } from "../../shared/components/ui/button";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "../../shared/components/ui/table";
import { User, userService } from "../services/user";

interface UsersTableProps {
  companyId: string;
  currentPage: number;
  perPage: number;
  searchName?: string;
  onPageChange: (page: number) => void;
  onPerPageChange: (perPage: number) => void;
}

export function UsersTable({
  companyId,
  currentPage,
  perPage,
  searchName,
  onPageChange,
  onPerPageChange: _, // Marcamos como no utilizado con guión bajo
}: UsersTableProps) {
  const [users, setUsers] = useState<User[]>([]);
  const [total, setTotal] = useState(0);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchUsers = useCallback(async () => {
    setIsLoading(true);
    setError(null);

    try {
      const response = await userService.getUsers(companyId, currentPage, perPage, searchName);

      setUsers(response.items);
      setTotal(response.total);
    } catch (err) {
      setError(err instanceof Error ? err.message : "Error al cargar usuarios");
      console.error("Error fetching users:", err);
    } finally {
      setIsLoading(false);
    }
  }, [companyId, currentPage, perPage, searchName]);

  useEffect(() => {
    void fetchUsers();
  }, [fetchUsers]);

  // Calcular el número total de páginas
  const totalPages = Math.max(1, Math.ceil(total / perPage));

  // Calcular los índices de los elementos mostrados
  const startIndex = (currentPage - 1) * perPage + 1;
  const endIndex = Math.min(startIndex + perPage - 1, total);

  return (
    <div className="space-y-4">
      {isLoading ? (
        <div className="flex justify-center items-center py-8">
          <Loader2 className="h-8 w-8 animate-spin text-primary" />
          <span className="ml-2 text-muted-foreground">Cargando usuarios...</span>
        </div>
      ) : error ? (
        <div className="flex items-center justify-center py-8 px-4 border border-red-200 rounded-md bg-red-50 dark:bg-red-900/20 dark:border-red-800/30">
          <AlertCircle className="h-5 w-5 text-red-500 dark:text-red-400 mr-2" />
          <p className="text-red-600 dark:text-red-400">{error}</p>
        </div>
      ) : users.length === 0 ? (
        <div className="flex justify-center items-center py-8 px-4 border border-border rounded-md bg-muted/20">
          <p className="text-muted-foreground">No se encontraron usuarios</p>
        </div>
      ) : (
        <>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nombre</TableHead>
                <TableHead>Email</TableHead>
                <TableHead className="w-24 text-right">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {users.map((user) => (
                <TableRow key={user.id}>
                  <TableCell className="font-medium">{user.name}</TableCell>
                  <TableCell>{user.email}</TableCell>
                  <TableCell className="text-right">
                    <Link
                      to="/$companyId/users/$id/edit"
                      params={{ companyId, id: user.id }}
                      className="inline-block"
                    >
                      <Button variant="ghost" size="icon" title="Editar usuario">
                        <Edit2 className="h-4 w-4" />
                      </Button>
                    </Link>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>

          {/* Paginación */}
          <div className="flex items-center justify-between px-2">
            <div className="text-sm text-muted-foreground">
              Mostrando {startIndex} a {endIndex} de {total} usuarios
            </div>
            <div className="flex items-center space-x-2">
              <Button
                variant="outline"
                size="sm"
                onClick={() => onPageChange(currentPage - 1)}
                disabled={currentPage <= 1}
              >
                <ChevronLeftIcon className="h-4 w-4" />
              </Button>
              <span className="text-sm mx-2">
                Página {currentPage} de {totalPages}
              </span>
              <Button
                variant="outline"
                size="sm"
                onClick={() => onPageChange(currentPage + 1)}
                disabled={currentPage >= totalPages}
              >
                <ChevronRightIcon className="h-4 w-4" />
              </Button>
            </div>
          </div>
        </>
      )}
    </div>
  );
}
