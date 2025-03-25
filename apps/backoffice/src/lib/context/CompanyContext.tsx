import { createContext, ReactNode, useContext, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

import { Company, companiesService, getAuthToken } from '../services/companies';

interface CompanyContextType {
  companies: Company[];
  loading: boolean;
  error: string | null;
  switchCompany: (companyId: string) => Promise<void>;
  refreshCompanies: () => Promise<void>;
  getCompanyById: (companyId: string) => Promise<Company | null>;
}

const CompanyContext = createContext<CompanyContextType | undefined>(undefined);

export function CompanyProvider({ children }: { children: ReactNode }) {
  const [companies, setCompanies] = useState<Company[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const navigate = useNavigate();

  const loadCompanies = async () => {
    try {
      setLoading(true);
      setError(null);

      // Obtener empresas del servicio
      const userCompanies = await companiesService.getUserCompanies();
      setCompanies(userCompanies);
    } catch (_err) {
      setError("Error al cargar las empresas");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    // Verificar si el usuario está autenticado antes de cargar las empresas
      const isAuthenticated = getAuthToken();

    if (isAuthenticated) {
      void loadCompanies();
    } else {
      setLoading(false);
    }
  }, []);

  const getCompanyById = async (companyId: string): Promise<Company | null> => {
    return companiesService.getCompanyById(companyId);
  };

  const switchCompany = async (companyId: string) => {
    try {
      // Verificar si el usuario tiene acceso a esta empresa
      const company = await getCompanyById(companyId);
      if (company) {
        await navigate(`/${companyId}/dashboard`);
      } else {
        setError("No tienes acceso a esta empresa");
      }
    } catch (_err) {
      setError("Error al cambiar de empresa");
    }
  };

  const refreshCompanies = async () => {
    await loadCompanies();
  };

  return (
    <CompanyContext.Provider
      value={{
        companies,
        loading,
        error,
        switchCompany,
        refreshCompanies,
        getCompanyById,
      }}
    >
      {children}
    </CompanyContext.Provider>
  );
}

export function useCompany() {
  const context = useContext(CompanyContext);
  if (context === undefined) {
    throw new Error("useCompany must be used within a CompanyProvider");
  }

  return context;
}
