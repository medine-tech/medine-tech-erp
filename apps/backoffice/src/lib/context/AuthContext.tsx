import { createContext, ReactNode, useContext, useEffect, useState } from "react";

import { ApiError, authService, UserInfo } from "../services/auth";

interface AuthContextType {
  isAuthenticated: boolean;
  loading: boolean;
  error: ApiError | null;
  userInfo: UserInfo | null;
  login: (email: string, password: string, rememberMe?: boolean) => Promise<string>; // Devuelve el company_id para redirección
  logout: () => void;
  clearError: () => void;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function useAuth() {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error("useAuth debe ser usado dentro de un AuthProvider");
  }

  return context;
}

export function AuthProvider({ children }: { children: ReactNode }) {
  const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<ApiError | null>(null);
  const [userInfo, setUserInfo] = useState<UserInfo | null>(null);

  // Verificar si el usuario está autenticado al cargar la aplicación
  useEffect(() => {
    const checkAuthStatus = async () => {
      try {
        const isAuth = authService.isAuthenticated();
        setIsAuthenticated(isAuth);

        if (isAuth) {
          // Intentar obtener datos actualizados del usuario desde el backend
          try {
            const userData = await authService.fetchUserInfo();
            setUserInfo(userData);
          } catch (fetchError) {
            console.error("Error al obtener datos del usuario desde la API:", fetchError);
            // Si falla la petición, usar datos almacenados localmente como respaldo
            const localUserData = authService.getUserInfo();
            setUserInfo(localUserData);
          }
        }
      } catch (error) {
        console.error("Error al verificar estado de autenticación:", error);
      } finally {
        setLoading(false);
      }
    };

    checkAuthStatus();
  }, []);

  // Función para iniciar sesión
  const login = async (
    email: string,
    password: string,
    rememberMe: boolean = false,
  ): Promise<string> => {
    setLoading(true);
    setError(null);

    try {
      const response = await authService.login({ email, password, rememberMe });

      // Guardar información del usuario si está disponible en la respuesta
      if (response.user) {
        setUserInfo(response.user);
        authService.saveAuthInfo(
          response.token,
          response.default_company_id,
          rememberMe,
          response.user,
        );
      } else {
        // Si no viene en la respuesta, usamos valores por defecto o los dejamos en blanco
        authService.saveAuthInfo(response.token, response.default_company_id, rememberMe);
        
        // Obtener datos completos del usuario desde la API
        try {
          const userData = await authService.fetchUserInfo();
          setUserInfo(userData);
        } catch (fetchError) {
          console.error("Error al obtener datos completos del usuario:", fetchError);
        }
      }

      setIsAuthenticated(true);

      return response.default_company_id;
    } catch (err) {
      setError(err as ApiError);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  // Función para cerrar sesión
  const logout = () => {
    void authService.logout();
    setIsAuthenticated(false);
    setUserInfo(null);
  };

  // Función para limpiar errores
  const clearError = () => {
    setError(null);
  };

  return (
    <AuthContext.Provider
      value={{
        isAuthenticated,
        loading,
        error,
        userInfo,
        login,
        logout,
        clearError,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
}
