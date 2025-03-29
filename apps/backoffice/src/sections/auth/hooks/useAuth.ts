import { useState, useEffect, useCallback } from 'react';

interface User {
  id: string;
  name: string;
  email: string;
  role: string;
}

interface LoginCredentials {
  email: string;
  password: string;
}

interface AuthState {
  user: User | null;
  isAuthenticated: boolean;
  isLoading: boolean;
}

export function useAuth() {
  const [state, setState] = useState<AuthState>({
    user: null,
    isAuthenticated: false,
    isLoading: true,
  });

  // Cargar usuario al iniciar
  useEffect(() => {
    const checkAuthStatus = async () => {
      try {
        // Simulamos obtener el usuario del localStorage (en producción usaría una API)
        const userJson = localStorage.getItem('user');
        
        if (userJson) {
          const user = JSON.parse(userJson);
          setState({
            user,
            isAuthenticated: true,
            isLoading: false,
          });
        } else {
          setState({
            user: null,
            isAuthenticated: false,
            isLoading: false,
          });
        }
      } catch (error) {
        setState({
          user: null,
          isAuthenticated: false,
          isLoading: false,
        });
      }
    };

    checkAuthStatus();
  }, []);

  const login = useCallback(async (credentials: LoginCredentials): Promise<User> => {
    setState(prev => ({ ...prev, isLoading: true }));
    
    try {
      // Aquí iría la llamada a la API real
      // Simulamos una respuesta exitosa
      const user: User = {
        id: '1',
        name: 'Usuario Demo',
        email: credentials.email,
        role: 'admin',
      };
      
      // Guardamos en localStorage (en producción usaría cookies HTTP-only)
      localStorage.setItem('user', JSON.stringify(user));
      
      setState({
        user,
        isAuthenticated: true,
        isLoading: false,
      });
      
      return user;
    } catch (error) {
      setState(prev => ({ ...prev, isLoading: false }));
      throw new Error('Error de autenticación');
    }
  }, []);

  const logout = useCallback(async () => {
    setState(prev => ({ ...prev, isLoading: true }));
    
    try {
      // Aquí iría la llamada a la API real para logout
      // Limpiamos localStorage
      localStorage.removeItem('user');
      
      setState({
        user: null,
        isAuthenticated: false,
        isLoading: false,
      });
    } catch (error) {
      setState(prev => ({ ...prev, isLoading: false }));
      throw new Error('Error al cerrar sesión');
    }
  }, []);

  return {
    ...state,
    login,
    logout,
  };
}
