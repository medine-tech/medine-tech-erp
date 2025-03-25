import { API_BASE_URL } from "../constants";

// Tipos para la API de autenticación
export interface UserInfo {
  id: string;
  name: string;
  email: string;
}

export interface LoginRequest {
  email: string;
  password: string;
  rememberMe?: boolean;
}

export interface LoginResponse {
  token: string;
  default_company_id: string;
  user?: UserInfo;
}

export interface ApiError {
  title: string;
  status: number;
  detail: string;
  errors?: Record<string, string[]>;
}

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
      throw new Error("No se pudo conectar con el servidor. Verifica tu conexión a internet.");
    }
  },

  // Cerrar sesión
  async logout(): Promise<void> {
    const token = this.getToken();

    if (token) {
      try {
        await fetch(`${API_BASE_URL}/logout`, {
          method: "POST",
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        });
      } catch (_error) {
        // Ignorar errores de cierre de sesión
      }
    }

    // Eliminar tokens y datos de usuario
    localStorage.removeItem("auth_token");
    localStorage.removeItem("default_company_id");
    sessionStorage.removeItem("auth_token");
    sessionStorage.removeItem("default_company_id");
  },

  // Guardar información de autenticación
  saveAuthInfo(
    token: string,
    companyId: string,
    rememberMe: boolean = false,
    userInfo?: UserInfo,
  ): void {
    const storage = rememberMe ? localStorage : sessionStorage;

    // Guardar el token con ambos nombres para compatibilidad
    storage.setItem("auth_token", token);

    // Guardar ID de empresa por defecto
    storage.setItem("default_company_id", companyId);

    // Guardar información del usuario si está disponible
    if (userInfo) {
      storage.setItem("user_info", JSON.stringify(userInfo));
    }
  },

  // Obtener token
  getToken(): string | null {
    // Intentar obtener el token con cualquiera de los dos nombres
    const authToken = localStorage.getItem("auth_token") ?? sessionStorage.getItem("auth_token");
    const legacyToken = localStorage.getItem("token") ?? sessionStorage.getItem("token");

    return authToken ?? legacyToken;
  },

  // Obtener ID de compañía por defecto (solo para redirección inicial)
  getDefaultCompanyId(): string | null {
    return (
      localStorage.getItem("default_company_id") ?? sessionStorage.getItem("default_company_id")
    );
  },

  // Verificar si el usuario está autenticado
  isAuthenticated(): boolean {
    return !!this.getToken();
  },

  // Obtener información del usuario actual
  getUserInfo(): UserInfo | null {
    const userInfoStr = localStorage.getItem("user_info") ?? sessionStorage.getItem("user_info");
    if (userInfoStr) {
      try {
        return JSON.parse(userInfoStr) as UserInfo;
      } catch (_e) {
        return null;
      }
    }

    return null;
  },

  // Obtener el nombre del usuario actual
  getUserName(): string {
    const userInfo = this.getUserInfo();

    return userInfo?.name ?? "Usuario";
  },
};
