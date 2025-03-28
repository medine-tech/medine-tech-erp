import { createFileRoute, redirect } from "@tanstack/react-router";

import { Dashboard } from "../pages/Dashboard";
import { authService } from "../lib/services/auth";

// La ruta del dashboard debe estar protegida
export const Route = createFileRoute("/$companyId/dashboard")({
  // Utilizamos el gancho beforeLoad para verificar la autenticación antes de cargar la ruta
  beforeLoad: () => {
    // Verificamos si el usuario está autenticado usando el servicio de autenticación
    // Este enfoque es consistente con el patrón DDD, donde el servicio encapsula la lógica de dominio
    const isAuthenticated = authService.isAuthenticated();
    
    // Si el usuario no está autenticado, lo redirigimos a la página de login
    if (!isAuthenticated) {
      // Utilizamos la función redirect de TanStack Router para la redirección
      throw redirect({
        to: "/login",
        // Incluimos la URL actual como parámetro para poder redireccionar al usuario
        // de vuelta a esta página después de iniciar sesión exitosamente
        search: {
          returnTo: window.location.pathname
        }
      });
    }
    
    // Si el usuario está autenticado, la ruta se cargará normalmente
  },
  // Componente que se renderizará cuando el usuario esté autenticado
  component: Dashboard,
});
