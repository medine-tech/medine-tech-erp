import { createContext, useContext, useState, useEffect, ReactNode } from "react";
import { authService, ApiError } from "../services/auth";

interface AuthContextType {
  isAuthenticated: boolean;
  loading: boolean;
  error: ApiError | null;
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

  // Verificar si el usuario está autenticado al cargar la aplicación
  useEffect(() => {
    const checkAuthStatus = () => {
      const isAuth = authService.isAuthenticated();
      setIsAuthenticated(isAuth);
      setLoading(false);
    };

    checkAuthStatus();
  }, []);

  // Función para iniciar sesión
  const login = async (email: string, password: string, rememberMe: boolean = false): Promise<string> => {
    setLoading(true);
    setError(null);
    
    try {
      const response = await authService.login({ email, password, rememberMe });
      authService.saveAuthInfo(response.token, response.default_company_id, rememberMe);
      
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
    authService.logout();
    setIsAuthenticated(false);
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
        login,
        logout,
        clearError,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
}
