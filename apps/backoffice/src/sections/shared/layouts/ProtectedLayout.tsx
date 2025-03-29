import { Outlet, useNavigate, useParams } from "@tanstack/react-router";
import { useEffect, useState } from "react";

import { UserProfile } from "../../auth/components/UserProfile";
import { useAuth } from "../../auth/context/AuthContext";
import { CompanySelector } from "../../companies/components/CompanySelector";
import { ThemeSwitch } from "../components/ui/theme-switch";

export function ProtectedLayout() {
  const { companyId } = useParams({ from: "/$companyId" });
  const navigate = useNavigate();
  const { isAuthenticated, loading: isLoading } = useAuth();
  const [isAuthChecked, setIsAuthChecked] = useState(false);

  // Verificar autenticación y redirigir si es necesario
  useEffect(() => {
    if (isLoading) {
      return;
    }

    if (!isAuthenticated) {
      const currentPath = window.location.pathname;
      void navigate({
        to: "/login",
        search: {
          returnTo: currentPath,
        },
      });
    } else {
      setIsAuthChecked(true);
    }
  }, [isLoading, isAuthenticated, navigate]);

  // Mostrar loader mientras se verifica la autenticación
  if (!isAuthChecked && isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-background">
        <div className="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-primary"></div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background">
      {/* Header compartido */}
      <header className="bg-card shadow-sm border-b sticky top-0 z-10">
        <div className="container mx-auto px-4 py-3 flex justify-between items-center">
          <div className="flex items-center space-x-4">
            <h1 className="text-xl font-medium text-foreground">Medine Tech</h1>
            {companyId && <CompanySelector currentCompanyId={companyId} />}
          </div>
          <div className="flex items-center space-x-4">
            <ThemeSwitch />
            <UserProfile />
          </div>
        </div>
      </header>

      {/* Contenido de la página (renderizado a través de Outlet) */}
      <main className="container mx-auto py-6 px-4">
        <Outlet />
      </main>
    </div>
  );
}
