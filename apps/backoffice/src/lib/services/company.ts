import { API_BASE_URL } from "../constants";
import { FirstCompanyFormValues } from "../validations/auth";
import { ApiError } from "./auth";

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
  }
};
