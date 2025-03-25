import { createContext, useContext, useEffect, useState, ReactNode } from 'react';
import { useNavigate } from 'react-router-dom';
import { Company, companiesService } from '../services/companies';

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
    } catch (err) {
      setError('Error al cargar las empresas');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    // Verificar si el usuario está autenticado antes de cargar las empresas
    const isAuthenticated = localStorage.getItem('auth_token') ||
                 sessionStorage.getItem('auth_token') ||
                 localStorage.getItem('token') ||
                 sessionStorage.getItem('token');

    if (isAuthenticated) {
      void loadCompanies();
    } else {
      setLoading(false);
    }
  }, []);

  const switchCompany = async (companyId: string) => {
    try {
      // Verificar si el usuario tiene acceso a esta empresa
      const company = await getCompanyById(companyId);
      if (company) {
        navigate(`/${companyId}/dashboard`);
      } else {
        setError('No tienes acceso a esta empresa');
      }
    } catch (err) {
      setError('Error al cambiar de empresa');
    }
  };

  const refreshCompanies = async () => {
    await loadCompanies();
  };

  const getCompanyById = async (companyId: string): Promise<Company | null> => {
    return companiesService.getCompanyById(companyId);
  };

  return (
    <CompanyContext.Provider
      value={{
        companies,
        loading,
        error,
        switchCompany,
        refreshCompanies,
        getCompanyById
      }}
    >
      {children}
    </CompanyContext.Provider>
  );
}

export function useCompany() {
  const context = useContext(CompanyContext);
  if (context === undefined) {
    throw new Error('useCompany debe ser usado dentro de un CompanyProvider');
  }
  return context;
}
