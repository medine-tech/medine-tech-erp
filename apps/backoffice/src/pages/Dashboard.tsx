import { useNavigate, useParams } from "@tanstack/react-router";
import { useEffect, useState } from "react";

import { UserProfile } from "../components/auth/UserProfile";
import { CompanySelector } from "../components/company/CompanySelector";
import { useAuth } from "../lib/context/AuthContext";
import { authService } from "../lib/services/auth";

export function Dashboard() {
  const { companyId } = useParams({ from: "/$companyId/dashboard" });
  const navigate = useNavigate();
  const { isAuthenticated, loading } = useAuth();
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

  // La función de logout se ha movido al componente UserProfile

  // El componente UserProfile se encargará de mostrar la información del usuario

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

          <UserProfile />
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
