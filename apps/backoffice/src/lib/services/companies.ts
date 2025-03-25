import { API_BASE_URL } from '../constants';

// Función auxiliar para obtener el token de autenticación
const getAuthToken = (): string | null => {
  return localStorage.getItem('auth_token') ||
         sessionStorage.getItem('auth_token') ||
         localStorage.getItem('token') ||
         sessionStorage.getItem('token');
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
   * Obtiene una empresa por su ID
   */
  async getCompanyById(companyId: string): Promise<Company | null> {
    const companies = await this.getUserCompanies();
    return companies.find(c => c.id === companyId) || null;
  },

  /**
   * Cambia la empresa actual
   *
   * Nota: Esta función solo actualiza el estado local. En una implementación
   * completa, se debería comunicar con el backend para cambiar la empresa actual.
   */
  async switchCompany(companyId: string): Promise<boolean> {
    try {
      // Cambiar la ruta actual con la nueva empresa seleccionada
      const url = new URL(window.location.href);
      url.pathname = `/${companyId}${url.pathname}`;
      window.history.pushState({}, '', url.toString());
      console.log(`Empresa cambiada localmente a: ${companyId}`);

      return true;
    } catch (error) {
      console.error('Error al cambiar de empresa:', error);
      return false;
    }
  }
};
