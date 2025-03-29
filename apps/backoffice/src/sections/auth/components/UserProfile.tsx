import { useNavigate, useParams } from "@tanstack/react-router";
import { useState } from "react";

import { Button } from "../../shared/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "../../shared/components/ui/dropdown-menu";
import { useAuth } from "../context/AuthContext";

export function UserProfile() {
  const { userInfo: user, logout } = useAuth();
  const { companyId } = useParams({ from: "/$companyId" });
  const navigate = useNavigate();
  const [isLoading, setIsLoading] = useState(false);

  // Usando datos del usuario del hook de autenticación
  const userName = user?.name ?? "Usuario";
  const userEmail = user?.email ?? "";

  const handleLogout = () => {
    try {
      setIsLoading(true);
      // La función logout es de tipo void, no devuelve una promesa
      logout();
      // Marcamos explicitamente que ignoramos la promesa de navegación
      void navigate({ to: "/login" });
    } catch (error: unknown) {
      console.error("Error al cerrar sesión:", error);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button
          variant="outline"
          className="flex items-center gap-2 text-foreground hover:text-primary transition-all duration-200 border-border/30 hover:border-primary/30 hover:bg-primary/5 dark:hover:bg-primary/10 dark:border-border/20 p-2 h-9 min-w-[42px] rounded-full"
          disabled={isLoading}
        >
          {/* Icono de usuario */}
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
            className={`${userName.length > 0 ? "mr-1.5" : ""} text-primary/80`}
          >
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
          </svg>

          {/* Nombre del usuario */}
          {(userName.length > 0 || isLoading) && (
            <span className="text-sm font-medium max-w-[120px] truncate">
              {isLoading ? "Cargando..." : userName}
            </span>
          )}

          {/* Icono de flecha */}
          {(userName.length > 0 || isLoading) && (
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
              className="ml-0.5 opacity-70"
            >
              <path d="m6 9 6 6 6-6" />
            </svg>
          )}
        </Button>
      </DropdownMenuTrigger>

      <DropdownMenuContent
        align="end"
        className="w-56 bg-card/95 backdrop-blur-sm border border-border/30 shadow-md dark:shadow-primary/20 dark:border-primary/20 rounded-lg p-1 animate-in fade-in-80 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2"
      >
        <DropdownMenuLabel className="text-muted-foreground font-medium text-xs px-2 py-1.5">
          Mi cuenta
        </DropdownMenuLabel>

        {user && (
          <div className="px-3 py-2 rounded-md bg-muted/30 dark:bg-primary/10 mx-1 my-1 border-l-2 border-primary/70">
            <p className="text-sm font-medium text-foreground truncate">{userName}</p>
            <p className="text-xs text-muted-foreground truncate">{userEmail}</p>
          </div>
        )}

        <DropdownMenuSeparator />

        <DropdownMenuItem className="text-foreground cursor-pointer rounded-md transition-all duration-150 py-2 my-0.5 px-2 mx-1 hover:bg-primary/10 dark:hover:bg-primary/30 dark:hover:text-primary-foreground hover:translate-x-1 hover:border-l-2 hover:border-primary/70 group">
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
            className="mr-2 group-hover:text-primary dark:group-hover:text-primary-foreground transition-colors duration-150"
          >
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
          </svg>
          <span>Mi perfil</span>
        </DropdownMenuItem>

        <DropdownMenuItem
          className="text-foreground cursor-pointer rounded-md transition-all duration-150 py-2 my-0.5 px-2 mx-1 hover:bg-primary/10 dark:hover:bg-primary/30 dark:hover:text-primary-foreground hover:translate-x-1 hover:border-l-2 hover:border-primary/70 group"
          onClick={() =>
            navigate({ to: "/$companyId/companies/list", params: { companyId: companyId || "" } })
          }
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
            className="mr-2 group-hover:text-primary dark:group-hover:text-primary-foreground transition-colors duration-150"
          >
            <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
            <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4" />
            <path d="M9 22V12" />
            <path d="M15 22V12" />
          </svg>
          <span>Lista de Compañías</span>
        </DropdownMenuItem>

        <DropdownMenuItem className="text-foreground cursor-pointer rounded-md transition-all duration-150 py-2 my-0.5 px-2 mx-1 hover:bg-primary/10 dark:hover:bg-primary/30 dark:hover:text-primary-foreground hover:translate-x-1 hover:border-l-2 hover:border-primary/70 group">
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
            className="mr-2 group-hover:text-primary dark:group-hover:text-primary-foreground transition-colors duration-150"
          >
            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
            <circle cx="12" cy="12" r="3" />
          </svg>
          <span>Configuración</span>
        </DropdownMenuItem>

        <DropdownMenuSeparator />

        <DropdownMenuItem
          className="text-red-600 dark:text-red-400 cursor-pointer hover:text-red-700 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-md transition-all duration-150 py-2 my-0.5 px-2 mx-1 hover:translate-x-1 hover:border-l-2 hover:border-red-500/70 group"
          onClick={handleLogout}
          disabled={isLoading}
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
            className="mr-2 group-hover:text-primary dark:group-hover:text-primary-foreground transition-colors duration-150"
          >
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <polyline points="16 17 21 12 16 7" />
            <line x1="21" y1="12" x2="9" y2="12" />
          </svg>
          <span>{isLoading ? "Cerrando sesión..." : "Cerrar sesión"}</span>
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}
