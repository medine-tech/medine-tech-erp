import { useCallback, useEffect, useState } from "react";

export interface Company {
  id: string;
  name: string;
  taxId: string;
  address?: string;
  email?: string;
  phone?: string;
  isActive: boolean;
}

interface CompaniesResponse {
  items: Company[];
  total: number;
}

export function useCompanies(): {
  companies: Company[];
  currentCompany: Company | null;
  isLoading: boolean;
  error: string | null;
  fetchCompanies: () => Promise<CompaniesResponse>;
  getCompanyById: (id: string) => Promise<Company | null>;
  loadCurrentCompany: (id: string) => Promise<void>;
  setCurrentCompany: React.Dispatch<React.SetStateAction<Company | null>>;
} {
  const [companies, setCompanies] = useState<Company[]>([]);
  const [currentCompany, setCurrentCompany] = useState<Company | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  // Función para obtener todas las empresas
  const fetchCompanies = useCallback(async (): Promise<CompaniesResponse> => {
    setIsLoading(true);
    setError(null);

    try {
      // Aquí iría la llamada a la API real
      // Simulamos datos de respuesta
      const mockCompanies: Company[] = [
        {
          id: "1",
          name: "Empresa Demo 1",
          taxId: "J-12345678-9",
          address: "Av. Principal #123",
          email: "contacto@empresa1.com",
          phone: "+58 212 1234567",
          isActive: true,
        },
        {
          id: "2",
          name: "Empresa Demo 2",
          taxId: "J-87654321-0",
          address: "Calle Secundaria #456",
          email: "contacto@empresa2.com",
          phone: "+58 212 7654321",
          isActive: true,
        },
      ];

      // Simulamos un tiempo de carga
      await new Promise((resolve) => {
        setTimeout(resolve, 1000);
      });

      setCompanies(mockCompanies);
      setIsLoading(false);

      return {
        items: mockCompanies,
        total: mockCompanies.length,
      };
    } catch (_err) {
      setError("Error al cargar las empresas");
      setIsLoading(false);
      console.error("Error al cargar empresas:", _err);
      throw new Error("Error al cargar las empresas");
    }
  }, []);

  // Función para obtener una empresa por su ID
  const getCompanyById = useCallback(
    async (id: string): Promise<Company | null> => {
      setIsLoading(true);

      try {
        // Simulamos llamada a API
        const company = companies.find((c) => c.id === id) ?? null;

        // Simulamos tiempo de carga
        await new Promise((resolve) => {
          setTimeout(resolve, 500);
        });

        setIsLoading(false);

        return company;
      } catch (_err) {
        setError("Error al obtener la empresa");
        setIsLoading(false);

        return null;
      }
    },
    [companies],
  );

  // Función para cargar una empresa actual
  const loadCurrentCompany = useCallback(
    async (id: string) => {
      try {
        const company = await getCompanyById(id);
        if (company) {
          setCurrentCompany(company);
        }
      } catch (_err) {
        console.error("Error al cargar la empresa actual:", _err);
      }
    },
    [getCompanyById],
  );

  // Efecto inicial para cargar empresas
  useEffect(() => {
    fetchCompanies().catch((err) => {
      console.error("Error en useEffect de useCompanies:", err);
    });
  }, [fetchCompanies]);

  return {
    companies,
    currentCompany,
    isLoading,
    error,
    fetchCompanies,
    getCompanyById,
    loadCurrentCompany,
    setCurrentCompany,
  };
}
