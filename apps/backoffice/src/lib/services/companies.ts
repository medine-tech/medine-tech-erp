import { API_BASE_URL } from '../constants';

// Función auxiliar para obtener el token de autenticación
const getAuthToken = (): string | null => {
  return localStorage.getItem('auth_token') ||
         sessionStorage.getItem('auth_token')
};

export interface Company {
  id: string;
  name: string;
}

export interface CompaniesResponse {
  items: Company[];
  total: number;
  per_page: number;
  current_page: number;
}

export const companiesService = {
  /**
   * Obtiene la lista de empresas a las que el usuario tiene acceso
   */
  async getUserCompanies(): Promise<Company[]> {
    try {
      const token = getAuthToken();
      if (!token) {
          console.warn('No authentication token found');
          return [];
      }

        const response = await fetch(`${API_BASE_URL}/auth/companies`, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        });

        if (!response.ok) {
            console.error(`Failed to fetch companies: ${response.status} ${response.statusText}`);
            return [];
        }
        const data = await response.json() as CompaniesResponse;
        return data.items || [];
    } catch (error: unknown) {
        console.error('Error fetching companies:', error instanceof Error ? error.message : String(error));
        return [];
    }
  },

  /**
   * Obtiene la empresa actual seleccionada
   */
  async getCurrentCompany(): Promise<Company | null> {
    const storedCompanyId = localStorage.getItem('currentCompanyId');
    const companies = await this.getUserCompanies();

    if (storedCompanyId && companies.length > 0) {
      const storedCompany = companies.find(c => c.id === storedCompanyId);
      if (storedCompany) return storedCompany;
    }
    return companies.length > 0 ? companies[0] : null;
  },

  /**
   * Cambia la empresa actual
   *
   * Nota: Esta función solo actualiza el estado local. En una implementación
   * completa, se debería comunicar con el backend para cambiar la empresa actual.
   */
  async switchCompany(companyId: string): Promise<boolean> {
    try {
      // Guardar la empresa seleccionada en localStorage
      localStorage.setItem('currentCompanyId', companyId);
      console.log(`Empresa cambiada localmente a: ${companyId}`);

      // No es necesario recargar la página completa
      // La navegación se manejará en el contexto de la empresa
      return true;
    } catch (error) {
      console.error('Error al cambiar de empresa:', error);
      return false;
    }
  }
};
