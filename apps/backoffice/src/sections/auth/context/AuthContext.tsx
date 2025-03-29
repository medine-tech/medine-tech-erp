import { createContext, ReactNode, useContext, useEffect, useState } from "react";

import { ApiError, authService, UserInfo } from "../services/auth";

interface AuthContextType {
  isAuthenticated: boolean;
  loading: boolean;
  error: ApiError | null;
  userInfo: UserInfo | null;
  login: (email: string, password: string, rememberMe?: boolean) => Promise<string>;
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

  useEffect(() => {
    const checkAuthStatus = async () => {
      try {
        const isAuth = authService.isAuthenticated();
        setIsAuthenticated(isAuth);

        if (isAuth) {
          try {
            const userData = await authService.fetchUserInfo();
            setUserInfo(userData);
          } catch (fetchError) {
            console.error("Error al obtener datos del usuario desde la API:", fetchError);
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

    void checkAuthStatus();
  }, []);

  const login = async (
    email: string,
    password: string,
    rememberMe: boolean = false,
  ): Promise<string> => {
    setLoading(true);
    setError(null);

    try {
      const response = await authService.login({ email, password, rememberMe });

      if (response.user) {
        setUserInfo(response.user);
        authService.saveAuthInfo(
          response.token,
          response.default_company_id,
          rememberMe,
          response.user,
        );
      } else {
        authService.saveAuthInfo(response.token, response.default_company_id, rememberMe);

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

  const logout = () => {
    void authService.logout();
    setIsAuthenticated(false);
    setUserInfo(null);
  };

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
