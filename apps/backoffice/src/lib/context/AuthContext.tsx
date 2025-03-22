import { createContext, useContext, useState, useEffect, ReactNode } from "react";
import { authService, ApiError } from "../services/auth";

interface AuthContextType {
  isAuthenticated: boolean;
  companyId: string | null;
  loading: boolean;
  error: ApiError | null;
  login: (email: string, password: string, rememberMe?: boolean) => Promise<void>;
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
  const [companyId, setCompanyId] = useState<string | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<ApiError | null>(null);

  // Verificar si el usuario está autenticado al cargar la aplicación
  useEffect(() => {
    const checkAuthStatus = () => {
      const isAuth = authService.isAuthenticated();
      const company = authService.getCompanyId();
      
      setIsAuthenticated(isAuth);
      setCompanyId(company);
      setLoading(false);
    };

    checkAuthStatus();
  }, []);

  // Función para iniciar sesión
  const login = async (email: string, password: string, rememberMe: boolean = false) => {
    setLoading(true);
    setError(null);
    
    try {
      const response = await authService.login({ email, password, rememberMe });
      authService.saveAuthInfo(response.token, response.default_company_id, rememberMe);
      
      setIsAuthenticated(true);
      setCompanyId(response.default_company_id);
    } catch (err) {
      setError(err as ApiError);
    } finally {
      setLoading(false);
    }
  };

  // Función para cerrar sesión
  const logout = () => {
    authService.logout();
    setIsAuthenticated(false);
    setCompanyId(null);
  };

  // Función para limpiar errores
  const clearError = () => {
    setError(null);
  };

  return (
    <AuthContext.Provider
      value={{
        isAuthenticated,
        companyId,
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
