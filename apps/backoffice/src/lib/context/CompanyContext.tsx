import { createContext, useContext, useEffect, useState, ReactNode } from 'react';
import { useNavigate } from 'react-router-dom';
import { Company, companiesService } from '../services/companies';

interface CompanyContextType {
  companies: Company[];
  currentCompany: Company | null;
  loading: boolean;
  error: string | null;
  switchCompany: (companyId: string) => Promise<void>;
  refreshCompanies: () => Promise<void>;
}

const CompanyContext = createContext<CompanyContextType | undefined>(undefined);

export function CompanyProvider({ children }: { children: ReactNode }) {
  const [companies, setCompanies] = useState<Company[]>([]);
  const [currentCompany, setCurrentCompany] = useState<Company | null>(null);
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
      
      // Obtener la empresa actual o usar la primera por defecto
      const storedCompanyId = localStorage.getItem('currentCompanyId');
      let current: Company | null = null;
      
      if (storedCompanyId) {
        current = userCompanies.find(c => c.id === storedCompanyId) || null;
      }
      
      if (!current && userCompanies.length > 0) {
        current = userCompanies[0];
        localStorage.setItem('currentCompanyId', current.id);
      }
      
      setCurrentCompany(current);
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
      const success = await companiesService.switchCompany(companyId);
      if (success) {
        const newCurrentCompany = companies.find(c => c.id === companyId) || null;
        setCurrentCompany(newCurrentCompany);
        
        // Navegar al dashboard con la nueva empresa sin recargar la página
        if (newCurrentCompany) {
          // Guardar el ID de la empresa actual para mantenerlo después de recargas manuales
          localStorage.setItem('currentCompanyId', newCurrentCompany.id);
          
          // Navegar al dashboard con la nueva empresa
          navigate(`/${newCurrentCompany.id}/dashboard`);
        }
      }
    } catch (err) {
      setError('Error al cambiar de empresa');
    }
  };

  const refreshCompanies = async () => {
    await loadCompanies();
  };

  return (
    <CompanyContext.Provider
      value={{
        companies,
        currentCompany,
        loading,
        error,
        switchCompany,
        refreshCompanies
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
