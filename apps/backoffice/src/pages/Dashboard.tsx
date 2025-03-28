import { useNavigate, useParams } from "@tanstack/react-router";
import { useEffect, useState } from "react";

import { CompanySelector } from "../components/company/CompanySelector";
import { Button } from "../components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "../components/ui/dropdown-menu";
import { useAuth } from "../lib/context/AuthContext";
import { authService } from "../lib/services/auth";

export function Dashboard() {
  const { companyId } = useParams({ from: "/$companyId/dashboard" });
  const navigate = useNavigate();
  const { userInfo, logout, isAuthenticated, loading } = useAuth();
  const [isAuthChecked, setIsAuthChecked] = useState(false);
  
  // Verificación de autenticación con soporte para múltiples pestañas
  useEffect(() => {
    // No realizamos comprobaciones mientras se está cargando el estado de autenticación
    if (loading) return;
    
    // Comprobación directa usando el servicio de autenticación (enfoque DDD)
    const isUserAuthenticated = isAuthenticated || authService.isAuthenticated();
    
    if (!isUserAuthenticated) {
      // Redirigir al login y guardar la URL actual para volver después
      const currentPath = window.location.pathname;
      navigate({
        to: "/login",
        search: {
          returnTo: currentPath
        }
      });
    } else {
      setIsAuthChecked(true);
    }
  }, [loading, isAuthenticated, navigate]);
  
  // No renderizar nada hasta que se complete la verificación de autenticación
  if (!isAuthChecked && loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-slate-800">
        <div className="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-sky-500"></div>
      </div>
    );
  }

  const handleLogout = async () => {
    try {
      await authService.logout();
      logout(); // Actualiza el estado en el contexto
      void navigate({ to: "/login" });
    } catch (error) {
      console.error("Error al cerrar sesión:", error);
    }
  };

  // Obtener el nombre del usuario del contexto o del servicio como respaldo
  const userName = userInfo?.name ?? authService.getUserName();

  return (
    <div className="min-h-screen bg-slate-100">
      {/* Header con dropdown de usuario */}
      <header className="bg-white shadow-sm border-b border-slate-200">
        <div className="container mx-auto px-4 py-4 flex justify-between items-center">
          <div className="flex items-center">
            <h1 className="text-xl font-medium text-slate-800 mr-6">Medine Tech</h1>
            
            {/* Selector de compañías */}
            <CompanySelector currentCompanyId={companyId} />
          </div>

          <DropdownMenu>
            <DropdownMenuTrigger asChild>
              <Button
                variant="outline"
                className="flex items-center gap-2 text-slate-700 hover:text-slate-900 pl-3 pr-2"
              >
                {/* Icono de usuario */}
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  className="mr-1"
                >
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>

                {/* Nombre del usuario */}
                <span className="text-sm font-medium">{userName}</span>

                {/* Icono de flecha */}
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="14"
                  height="14"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  className="ml-1"
                >
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </Button>
            </DropdownMenuTrigger>

            <DropdownMenuContent align="end" className="w-56">
              <DropdownMenuLabel className="text-slate-500 font-normal text-xs">
                Mi cuenta
              </DropdownMenuLabel>

              <DropdownMenuSeparator />

              <DropdownMenuItem className="text-slate-700 cursor-pointer">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  className="mr-2"
                >
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
                <span>Mi perfil</span>
              </DropdownMenuItem>

              <DropdownMenuItem className="text-slate-700 cursor-pointer">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  className="mr-2"
                >
                  <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                  <circle cx="12" cy="12" r="3" />
                </svg>
                <span>Configuración</span>
              </DropdownMenuItem>

              <DropdownMenuSeparator />

              <DropdownMenuItem
                className="text-red-600 cursor-pointer focus:text-red-700"
                onClick={handleLogout}
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  className="mr-2"
                >
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                  <polyline points="16 17 21 12 16 7" />
                  <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span>Cerrar sesión</span>
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      </header>

      {/* Contenido principal */}
      <div className="container mx-auto py-8 px-4">
        <h2 className="text-2xl font-bold mb-6">Panel de control</h2>
        <div className="bg-white shadow-md rounded-lg p-6">
          <p className="text-gray-700 mb-4">
            Bienvenido al panel de control de Medine. Esta es una página de ejemplo.
          </p>
          <p className="text-sm text-gray-600">ID de Compañía: {companyId}</p>
        </div>
      </div>
    </div>
  );
}
