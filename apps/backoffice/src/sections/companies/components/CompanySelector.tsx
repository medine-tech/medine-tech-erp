import { useNavigate } from "@tanstack/react-router";

import { Button } from "../../shared/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "../../shared/components/ui/dropdown-menu";
import { useCompanySelector } from "../hooks/useCompanySelector";
import { Company } from "../services/company";

interface CompanySelectorProps {
  currentCompanyId: string;
}

export function CompanySelector({ currentCompanyId }: CompanySelectorProps) {
  const navigate = useNavigate();
  const { companies, currentCompany, isLoading, error } = useCompanySelector(currentCompanyId);

  const handleCompanyChange = (company: Company) => {
    void navigate({
      to: "/$companyId/dashboard",
      params: { companyId: company.id },
    });
  };

  if (isLoading) {
    return (
      <Button
        variant="outline"
        disabled
        className="flex items-center gap-2 text-muted-foreground border-border/50 px-3 py-1.5 h-9"
      >
        <div className="w-4 h-4 border-2 border-t-primary rounded-full animate-spin"></div>
        <span className="text-sm">Cargando...</span>
      </Button>
    );
  }

  if (error || !currentCompany) {
    return (
      <Button
        variant="outline"
        disabled
        className="flex items-center gap-2 border-red-300/30 text-red-500 dark:text-red-400 px-3 py-1.5 h-9"
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
        >
          <path d="M18 6 6 18" />
          <path d="m6 6 12 12" />
        </svg>
        <span className="text-sm">Error</span>
      </Button>
    );
  }

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button
          variant="outline"
          className="flex items-center gap-2 text-foreground hover:text-primary transition-all duration-200 border-border/30 hover:border-primary/30 hover:bg-primary/5 dark:hover:bg-primary/10 dark:border-border/20 px-3 py-1.5 h-9"
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

      <DropdownMenuContent
        align="start"
        className="w-56 bg-card/95 backdrop-blur-sm border border-border/30 shadow-md dark:shadow-primary/20 dark:border-primary/20 rounded-lg p-1 animate-in fade-in-80 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2"
      >
        <DropdownMenuLabel className="text-muted-foreground font-medium text-xs px-2 py-1.5">
          Mis compañías
        </DropdownMenuLabel>

        <DropdownMenuSeparator />

        {companies.length === 0 ? (
          <div className="px-3 py-2.5 text-sm text-muted-foreground italic rounded-md bg-muted/50 mx-1 my-1">
            No tienes compañías disponibles
          </div>
        ) : (
          companies.map((company: Company) => (
            <DropdownMenuItem
              key={company.id}
              className={`text-foreground cursor-pointer px-2 py-1.5 mx-1 my-0.5 rounded-md transition-all duration-150 ${
                company.id === currentCompanyId
                  ? "bg-primary/15 dark:bg-primary/25 font-medium border-l-2 border-primary"
                  : "hover:bg-primary/10 dark:hover:bg-primary/30 hover:translate-x-1 hover:border-l-2 hover:border-primary/70 dark:hover:text-primary-foreground"
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
