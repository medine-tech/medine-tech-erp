// Tipos para la API de autenticación
export interface LoginRequest {
  email: string;
  password: string;
  rememberMe?: boolean;
}

export interface LoginResponse {
  token: string;
  default_company_id: string;
}

export interface ApiError {
  title: string;
  status: number;
  detail: string;
  errors?: Record<string, string[]>;
}

import { API_BASE_URL } from "../constants";

// Servicio de autenticación
export const authService = {
  // Iniciar sesión
  async login(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      const response = await fetch(`${API_BASE_URL}/login`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(credentials),
      });

      const data = await response.json();

      if (!response.ok) {
        // Convertir la respuesta de error a un formato estandarizado
        const apiError: ApiError = {
          title: data.title || "Error",
          status: response.status,
          detail: data.detail || "Ha ocurrido un error durante el inicio de sesión",
          errors: data.errors,
        };
        throw apiError;
      }

      return data as LoginResponse;
    } catch (error) {
      if ((error as ApiError).status) {
        throw error;
      }
      // Error de red u otro error inesperado
      throw {
        title: "Error de conexión",
        status: 0,
        detail: "No se pudo conectar con el servidor. Verifica tu conexión a internet.",
      } as ApiError;
    }
  },

  // Cerrar sesión
  logout(): void {
    localStorage.removeItem("auth_token");
    localStorage.removeItem("default_company_id");
    sessionStorage.removeItem("auth_token");
    sessionStorage.removeItem("default_company_id");
  },

  // Guardar información de autenticación
  saveAuthInfo(token: string, companyId: string, rememberMe: boolean = false): void {
    const storage = rememberMe ? localStorage : sessionStorage;
    storage.setItem("auth_token", token);
    // No guardamos company_id localmente, se manejará a través de la URL
    storage.setItem("default_company_id", companyId); // Guardamos solo como referencia inicial
  },

  // Obtener token
  getToken(): string | null {
    return localStorage.getItem("auth_token") || sessionStorage.getItem("auth_token");
  },

  // Obtener ID de compañía por defecto (solo para redirección inicial)
  getDefaultCompanyId(): string | null {
    return localStorage.getItem("default_company_id") || sessionStorage.getItem("default_company_id");
  },

  // Verificar si el usuario está autenticado
  isAuthenticated(): boolean {
    return !!this.getToken();
  },
};
