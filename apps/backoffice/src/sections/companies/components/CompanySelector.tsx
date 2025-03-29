import { useNavigate } from "@tanstack/react-router";
import { useEffect, useState } from "react";

import { Button } from "../../shared/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "../../shared/components/ui/dropdown-menu";
import { useCompanies } from "../context/CompanyContext";
import { Company } from "../services/company";

interface CompanySelectorProps {
  currentCompanyId: string;
}

export function CompanySelector({ currentCompanyId }: CompanySelectorProps) {
  const navigate = useNavigate();
  const { companies, isLoading, error, fetchCompanies } = useCompanies();
  const [currentCompany, setCurrentCompany] = useState<Company | null>(null);

  useEffect(() => {
    async function loadData() {
      try {
        const result = await fetchCompanies();

        // Encontrar la compañía actual según el ID
        const company = result.items.find((company) => company.id === currentCompanyId);

        if (company) {
          setCurrentCompany(company);
        }
      } catch (err) {
        console.error("Error al cargar compañías:", err);
      }
    }

    void loadData();
  }, [currentCompanyId, fetchCompanies]);

  const handleCompanyChange = (company: Company) => {
    void navigate({
      to: "/$companyId/dashboard",
      params: { companyId: company.id },
    });
  };

  if (isLoading) {
    return (
      <Button variant="outline" disabled className="mr-4">
        <span className="text-sm">Cargando...</span>
      </Button>
    );
  }

  if (error || !currentCompany) {
    return (
      <Button variant="outline" disabled className="mr-4 border-red-300 text-red-500">
        <span className="text-sm">Error</span>
      </Button>
    );
  }

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button
          variant="outline"
          className="mr-4 flex items-center gap-2 text-slate-700 hover:text-slate-900"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
            className="mr-1"
          >
            <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
            <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4" />
            <path d="M9 22V12" />
            <path d="M15 22V12" />
          </svg>

          <span className="text-sm font-medium max-w-[150px] truncate">{currentCompany.name}</span>

          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="14"
            height="14"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
            className="ml-1"
          >
            <path d="m6 9 6 6 6-6" />
          </svg>
        </Button>
      </DropdownMenuTrigger>

      <DropdownMenuContent align="start" className="w-56">
        <DropdownMenuLabel className="text-slate-500 font-normal text-xs">
          Mis compañías
        </DropdownMenuLabel>

        <DropdownMenuSeparator />

        {companies.length === 0 ? (
          <div className="px-2 py-2 text-sm text-slate-500">No tienes compañías disponibles</div>
        ) : (
          companies.map((company) => (
            <DropdownMenuItem
              key={company.id}
              className={`text-slate-700 cursor-pointer ${
                company.id === currentCompanyId ? "bg-slate-100 font-medium" : ""
              }`}
              onClick={() => handleCompanyChange(company)}
            >
              <span className="truncate">{company.name}</span>
            </DropdownMenuItem>
          ))
        )}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}
