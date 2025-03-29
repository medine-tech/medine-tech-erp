import { useNavigate, useParams } from "@tanstack/react-router";
import { useEffect, useState } from "react";

import { UserProfile } from "../../auth/components";
import { useAuth } from "../../auth/hooks/useAuth";
import { CompanySelector } from "../../companies/components";

export function DashboardPage() {
  const { companyId } = useParams({ from: "/$companyId/dashboard" });
  const navigate = useNavigate();
  const { isAuthenticated, isLoading } = useAuth();
  const [isAuthChecked, setIsAuthChecked] = useState(false);
  
  useEffect(() => {
    if (isLoading) return;
    
    if (!isAuthenticated) {
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
  }, [isLoading, isAuthenticated, navigate]);
  
  if (!isAuthChecked && isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-background">
        <div className="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-primary"></div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background">
      <header className="bg-card shadow-sm border-b">
        <div className="container mx-auto px-4 py-4 flex justify-between items-center">
          <div className="flex items-center">
            <h1 className="text-xl font-medium text-foreground mr-6">Medine Tech</h1>
            <CompanySelector currentCompanyId={companyId || ''} />
          </div>
          <UserProfile />
        </div>
      </header>

      <div className="container mx-auto py-8 px-4">
        <h2 className="text-2xl font-bold mb-6">Panel de control</h2>
        <div className="bg-card shadow-md rounded-lg p-6">
          <p className="text-muted-foreground mb-4">
            Bienvenido al panel de control de Medine. Esta es una página de ejemplo.
          </p>
          <p className="text-sm text-muted-foreground">ID de Compañía: {companyId}</p>
        </div>
      </div>
    </div>
  );
}

export default DashboardPage;
