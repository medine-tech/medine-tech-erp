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
      <header className="bg-card/80 backdrop-blur-md border-b border-border/40 sticky top-0 z-10 dark:bg-card/70 shadow-sm dark:shadow-primary/5">
        <div className="container mx-auto px-4 py-3 flex justify-between items-center">
          <div className="flex items-center space-x-3">
            <button 
              onClick={() => navigate({ to: "/$companyId/dashboard", params: { companyId: companyId || "" } })}
              className="flex items-center text-foreground hover:text-primary transition-all duration-300 transform hover:scale-[1.03] focus:outline-none focus:ring-2 focus:ring-primary/40 focus:ring-offset-2 focus:ring-offset-background rounded-md p-1.5"
              title="Ir al Panel de Control"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="mr-2 text-primary"
              >
                <rect width="7" height="9" x="3" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="3" rx="1" />
                <rect width="7" height="9" x="14" y="12" rx="1" />
                <rect width="7" height="5" x="3" y="16" rx="1" />
              </svg>
              <h1 className="text-xl font-medium bg-gradient-to-r from-primary to-indigo-500 dark:from-primary dark:to-blue-400 bg-clip-text text-transparent">Medine Tech</h1>
            </button>
            {companyId && <CompanySelector currentCompanyId={companyId} />}
          </div>
          <div className="flex items-center space-x-3">
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
