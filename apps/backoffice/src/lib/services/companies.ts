import { API_BASE_URL } from "../constants";

// Función auxiliar para obtener el token de autenticación
const getAuthToken = (): string | null => {
  return (
    localStorage.getItem("auth_token") ??
    sessionStorage.getItem("auth_token") ??
    localStorage.getItem("token") ??
    sessionStorage.getItem("token")
  );
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
        return [];
      }

      const response = await fetch(`${API_BASE_URL}/auth/companies`, {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
          Accept: "application/json",
        },
      });

      if (!response.ok) {
        return [];
      }
      const data = (await response.json()) as CompaniesResponse;

      return data.items ?? [];
    } catch (_error: unknown) {
      return [];
    }
  },

  /**
   * Obtiene una empresa por su ID
   */
  async getCompanyById(companyId: string): Promise<Company | null> {
    const companies = await this.getUserCompanies();

    return companies.find((c) => c.id === companyId) ?? null;
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
      // Check if the path already contains a company ID pattern
      const pathParts = url.pathname.split("/").filter(Boolean);
      if (pathParts.length > 0) {
        // Replace the first part if it looks like a company ID
        pathParts[0] = companyId;
        url.pathname = `/${pathParts.join("/")}`;
      } else {
        // No path or empty path, just add company ID
        url.pathname = `/${companyId}/dashboard`;
      }

      window.history.pushState({}, "", url.toString());
      return true;
    } catch (_error) {
      return false;
    }
  },
};
