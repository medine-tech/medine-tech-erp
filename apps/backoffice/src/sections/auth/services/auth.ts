import { API_BASE_URL } from "../../shared/config";

// Tipos para la API de autenticación
export interface UserInfo {
  id: string;
  name: string;
  email: string;
  defaultCompanyId?: string;
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
      } catch (error) {
        console.error("Error al cerrar sesión:", error);
      }
    }

    localStorage.removeItem("auth_token");
    localStorage.removeItem("default_company_id");
    localStorage.removeItem("user_info");
  },

  // Guardar información de autenticación
  saveAuthInfo(
    token: string,
    companyId: string,
    _rememberMe: boolean = false,
    userInfo?: UserInfo,
  ): void {
    localStorage.setItem("auth_token", token);
    localStorage.setItem("default_company_id", companyId);

    if (userInfo) {
      localStorage.setItem("user_info", JSON.stringify(userInfo));
    }
  },

  // Obtener token
  getToken(): string | null {
    return localStorage.getItem("auth_token");
  },

  // Obtener ID de compañía por defecto (solo para redirección inicial)
  getDefaultCompanyId(): string | null {
    return localStorage.getItem("default_company_id");
  },

  // Verificar si el usuario está autenticado
  isAuthenticated(): boolean {
    return !!this.getToken();
  },

  // Obtener información del usuario actual
  getUserInfo(): UserInfo | null {
    const userInfoStr = localStorage.getItem("user_info");
    if (userInfoStr) {
      try {
        return JSON.parse(userInfoStr) as UserInfo;
      } catch (e) {
        console.error("Error al parsear la información del usuario:", e);

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

  // Obtener la información del usuario autenticado desde el backend
  async fetchUserInfo(): Promise<UserInfo> {
    try {
      const token = this.getToken();
      if (!token) {
        throw new Error("No hay sesión de usuario");
      }

      const response = await fetch(`${API_BASE_URL}/auth/user`, {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
        },
      });

      if (!response.ok) {
        const errorData = await response.json();
        const apiError: ApiError = {
          title: errorData.title || "Error",
          status: response.status,
          detail: errorData.details || "Ha ocurrido un error al obtener la información del usuario",
          errors: errorData.errors,
        };
        throw apiError;
      }

      const userData = await response.json();

      this.saveUserInfo(userData);

      return userData;
    } catch (error) {
      if ((error as ApiError).status) {
        throw error;
      }
      throw new Error("Ha ocurrido un error al obtener la información del usuario");
    }
  },

  // Guardar la información del usuario en el localStorage
  saveUserInfo(userInfo: UserInfo): void {
    localStorage.setItem("user_info", JSON.stringify(userInfo));
  },
};
