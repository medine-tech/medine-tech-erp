import { createContext, ReactNode, useCallback, useContext, useEffect, useState } from "react";

import { ApiError } from "../../auth/services/auth";
import { useAuth } from "../../auth/context/AuthContext";
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
  const { isAuthenticated } = useAuth();
  const [companies, setCompanies] = useState<Company[]>([]);
  const [currentCompany, setCurrentCompany] = useState<Company | null>(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<ApiError | null>(null);
  const [initialized, setInitialized] = useState(false);

  // Usar useCallback para evitar que la función se recree en cada render
  const fetchCompanies = useCallback(async (page = 1, perPage = 10): Promise<CompanyPagination> => {
    if (!isAuthenticated) {
      const emptyResponse: CompanyPagination = {
        items: [],
        total: 0,
        current_page: page,
        per_page: perPage
      };
      return emptyResponse;
    }

    // Solo permitir una solicitud activa a la vez
    if (isLoading) {
      const emptyResponse: CompanyPagination = {
        items: companies,
        total: companies.length,
        current_page: page,
        per_page: perPage
      };
      return emptyResponse;
    }
    
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
  }, []);

  // Usar useCallback para las demás funciones
  const getCompanyById = useCallback((id: string): Company | null => {
    return companies.find((company) => company.id === id) || null;
  }, [companies]);

  const clearError = useCallback(() => {
    setError(null);
  }, []);

  useEffect(() => {
    // Solo cargar compañías si el usuario está autenticado y no se ha inicializado antes
    if (isAuthenticated && !initialized) {
      setInitialized(true);
      fetchCompanies().catch((err) => {
        console.error("Error al cargar las compañías:", err);
      });
    }
  }, [isAuthenticated, initialized, fetchCompanies]);

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
