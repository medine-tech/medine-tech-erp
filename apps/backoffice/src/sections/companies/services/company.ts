import { FirstCompanyFormValues } from "../../auth/lib/validations";
// Importamos los tipos desde su nueva ubicación
import { ApiError, authService } from "../../auth/services/auth";
import { API_BASE_URL } from "../../shared/config";

// Interfaz para la compañía
export interface Company {
  id: string;
  name: string;
}

// Interfaz para la paginación de compañías
export interface CompanyPagination {
  items: Company[];
  total: number;
  per_page: number;
  current_page: number;
}

// Servicio para gestión de compañías
export const companyService = {
  // Registrar la primera compañía con usuario administrador
  async registerFirstCompany(data: FirstCompanyFormValues): Promise<void> {
    try {
      const response = await fetch(`${API_BASE_URL}/backoffice/first-companies`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      });

      if (!response.ok) {
        const errorData = await response.json();
        const apiError: ApiError = {
          title: errorData.title || "Error",
          status: response.status,
          detail: errorData.details || "Ha ocurrido un error al registrar la compañía",
          errors: errorData.errors,
        };
        throw apiError;
      }
    } catch (error) {
      if ((error as ApiError).status) {
        throw error;
      }
      throw new Error("Error de conexión al intentar registrar la compañía");
    }
  },

  // Obtener la lista de compañías del usuario actual
  async getCompanies(page: number = 1, perPage: number = 10): Promise<CompanyPagination> {
    try {
      const token = authService.getToken();
      if (!token) {
        throw new Error("No hay sesión de usuario");
      }

      const response = await fetch(
        `${API_BASE_URL}/auth/companies?page=${page}&per_page=${perPage}`,
        {
          method: "GET",
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        },
      );

      if (!response.ok) {
        const errorData = await response.json();
        const apiError: ApiError = {
          title: errorData.title || "Error",
          status: response.status,
          detail: errorData.details || "Ha ocurrido un error al obtener las compañías",
          errors: errorData.errors,
        };
        throw apiError;
      }

      return (await response.json()) as CompanyPagination;
    } catch (error) {
      if ((error as ApiError).status) {
        throw error;
      }
      throw new Error("Ha ocurrido un error al obtener las compañías");
    }
  },
};
