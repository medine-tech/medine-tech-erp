import { createContext, ReactNode, useContext, useEffect, useState } from "react";

import { ApiError } from "../../auth/services/auth";
import { Company, CompanyPagination, companyService } from "../services/company";

interface CompanyContextType {
  companies: Company[];
  currentCompany: Company | null;
  isLoading: boolean;
  error: ApiError | null;
  fetchCompanies: (page?: number, perPage?: number) => Promise<CompanyPagination>;
  getCompanyById: (id: string) => Company | null;
  setCurrentCompany: (company: Company | null) => void;
  clearError: () => void;
}

const CompanyContext = createContext<CompanyContextType | undefined>(undefined);

export function useCompanies() {
  const context = useContext(CompanyContext);
  if (context === undefined) {
    throw new Error("useCompanies debe ser usado dentro de un CompanyProvider");
  }

  return context;
}

export function CompanyProvider({ children }: { children: ReactNode }) {
  const [companies, setCompanies] = useState<Company[]>([]);
  const [currentCompany, setCurrentCompany] = useState<Company | null>(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<ApiError | null>(null);

  const fetchCompanies = async (page = 1, perPage = 10): Promise<CompanyPagination> => {
    setIsLoading(true);
    setError(null);

    try {
      const response = await companyService.getCompanies(page, perPage);
      setCompanies(response.items);
      setIsLoading(false);

      return response;
    } catch (err) {
      setError(err as ApiError);
      setIsLoading(false);
      throw err;
    }
  };

  const getCompanyById = (id: string): Company | null => {
    return companies.find((company) => company.id === id) || null;
  };

  const clearError = () => {
    setError(null);
  };

  useEffect(() => {
    fetchCompanies().catch((err) => {
      console.error("Error al cargar las compañías:", err);
    });
  }, []);

  const value = {
    companies,
    currentCompany,
    isLoading,
    error,
    fetchCompanies,
    getCompanyById,
    setCurrentCompany,
    clearError,
  };

  return <CompanyContext.Provider value={value}>{children}</CompanyContext.Provider>;
}
