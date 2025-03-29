import { Link, useParams, useSearch } from "@tanstack/react-router";
import { Plus, Search, X } from "lucide-react";
import { useState } from "react";

import { CompaniesTable } from "../components/CompaniesTable";
import { CompanySearchForm } from "../components/CompanySearchForm";
import { UserProfile } from "../../auth/components/UserProfile";
import { Breadcrumb } from "../../shared/components/ui/breadcrumb";
import { Button } from "../../shared/components/ui/button";

export function CompaniesListPage() {
  const { companyId } = useParams({ from: "/$companyId/companies/list" });
  
  // Definir tipo para los parámetros de búsqueda
  type SearchParams = {
    name?: string;
  };
  
  const search = useSearch({ from: "/$companyId/companies/list" }) as SearchParams;
  const [currentPage, setCurrentPage] = useState(1);
  const [perPage, setPerPage] = useState(10);
  const [isSearchFormVisible, setIsSearchFormVisible] = useState(!!search.name);

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
          <Breadcrumb segments={[{ label: "Compañías" }]} />
        </div>

        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
            <h2 className="text-2xl font-bold">Listado de Compañías</h2>
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
          <Link to="/$companyId/companies/create" params={{ companyId }}>
            <Button>
              <Plus className="h-4 w-4 mr-2" />
              Crear Compañía
            </Button>
          </Link>
        </div>
        
        {isSearchFormVisible && (
          <CompanySearchForm 
            companyId={companyId || ""} 
            onClose={() => setIsSearchFormVisible(false)} 
          />
        )}

        <div className="bg-card shadow-md rounded-lg p-6">
          <CompaniesTable
            companyId={companyId || ""}
            currentPage={currentPage}
            perPage={perPage}
            searchName={search.name}
            onPageChange={setCurrentPage}
            onPerPageChange={setPerPage}
          />
        </div>
      </div>
    </div>
  );
}
