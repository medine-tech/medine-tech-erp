import { Link, useParams, useSearch } from "@tanstack/react-router";
import { Plus, Search, X } from "lucide-react";
import { useState } from "react";

import { Breadcrumb } from "../../shared/components/ui/breadcrumb";
import { Button } from "../../shared/components/ui/button";
import { UserSearchForm } from "../components/UserSearchForm";
import { UsersTable } from "../components/UsersTable";

export function UsersListPage() {
  const { companyId } = useParams({ from: "/$companyId/users/list" });

  // Definir tipo para los parámetros de búsqueda
  type SearchParams = {
    name?: string;
  };

  const search = useSearch({ from: "/$companyId/users/list" }) as SearchParams;
  const [currentPage, setCurrentPage] = useState(1);
  const [perPage, setPerPage] = useState(10);
  const [isSearchFormVisible, setIsSearchFormVisible] = useState(!!search.name);

  return (
    <>
      <div className="mb-6">
        <Breadcrumb segments={[{ label: "Usuarios" }]} />
      </div>

      <div className="flex justify-between items-center mb-6">
        <div className="flex items-center space-x-4">
          <h2 className="text-2xl font-bold">Listado de Usuarios</h2>
          <Button
            variant={isSearchFormVisible ? "secondary" : "outline"}
            size="sm"
            onClick={() => setIsSearchFormVisible(!isSearchFormVisible)}
          >
            {isSearchFormVisible ? (
              <>
                <X className="h-4 w-4 mr-2" />
                Ocultar búsqueda
              </>
            ) : (
              <>
                <Search className="h-4 w-4 mr-2" />
                Buscar
              </>
            )}
          </Button>
        </div>
        <Link to="/$companyId/users/create" params={{ companyId }}>
          <Button>
            <Plus className="h-4 w-4 mr-2" />
            Crear Usuario
          </Button>
        </Link>
      </div>

      {isSearchFormVisible && (
        <UserSearchForm
          companyId={companyId || ""}
          onClose={() => setIsSearchFormVisible(false)}
        />
      )}

      <div className="bg-card shadow-md rounded-lg p-6">
        <UsersTable
          companyId={companyId || ""}
          currentPage={currentPage}
          perPage={perPage}
          searchName={search.name}
          onPageChange={setCurrentPage}
          onPerPageChange={setPerPage}
        />
      </div>
    </>
  );
}
