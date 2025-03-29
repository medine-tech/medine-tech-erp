import { authService } from "../../auth/services/auth";

// Definir tipo para Usuario
export interface User {
  id: string;
  name: string;
  email: string;
}

// Definir tipo para la paginación de usuarios
export interface UserPagination {
  items: User[];
  total: number;
  per_page: number;
  current_page: number;
}

// Definir tipo para la creación de usuario
export interface CreateUserPayload {
  name: string;
  email: string;
  password: string;
}

// Definir tipo para la actualización de usuario
export interface UpdateUserPayload {
  name: string;
}

const API_BASE_URL = import.meta.env.VITE_API_URL;

class UserService {
  async getUsers(
    companyId: string,
    page: number = 1,
    perPage: number = 10,
    searchName?: string,
  ): Promise<UserPagination> {
    try {
      // Obtener token de autenticación
      const token = authService.getToken();
      if (!token) {
        throw new Error("No se ha encontrado un token de autenticación");
      }

      let url = `${API_BASE_URL}/backoffice/${companyId}/users?page=${page}&per_page=${perPage}`;

      if (searchName) {
        url += `&name=${encodeURIComponent(searchName)}`;
      }

      const response = await fetch(url, {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
          accept: "application/json",
        },
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.detail || "Error al obtener usuarios");
      }

      return await response.json();
    } catch (error) {
      console.error("Error en getUsers:", error);
      throw error;
    }
  }

  async getUserById(companyId: string, userId: string): Promise<User> {
    try {
      const token = authService.getToken();
      if (!token) {
        throw new Error("No se ha encontrado un token de autenticación");
      }

      const response = await fetch(`${API_BASE_URL}/backoffice/${companyId}/users/${userId}`, {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
          accept: "application/json",
        },
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.detail || "Error al obtener el usuario");
      }

      return await response.json();
    } catch (error) {
      console.error("Error en getUserById:", error);
      throw error;
    }
  }

  async createUser(companyId: string, userData: CreateUserPayload): Promise<User> {
    try {
      const token = authService.getToken();
      if (!token) {
        throw new Error("No se ha encontrado un token de autenticación");
      }

      const response = await fetch(`${API_BASE_URL}/backoffice/${companyId}/users`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
          accept: "application/json",
        },
        body: JSON.stringify(userData),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.detail || "Error al crear el usuario");
      }

      return await response.json();
    } catch (error) {
      console.error("Error en createUser:", error);
      throw error;
    }
  }

  async updateUser(companyId: string, userId: string, userData: UpdateUserPayload): Promise<User> {
    try {
      const token = authService.getToken();
      if (!token) {
        throw new Error("No se ha encontrado un token de autenticación");
      }

      const response = await fetch(`${API_BASE_URL}/backoffice/${companyId}/users/${userId}`, {
        method: "PUT",
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
          accept: "application/json",
        },
        body: JSON.stringify(userData),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.detail || "Error al actualizar el usuario");
      }

      return await response.json();
    } catch (error) {
      console.error("Error en updateUser:", error);
      throw error;
    }
  }
}

export const userService = new UserService();
