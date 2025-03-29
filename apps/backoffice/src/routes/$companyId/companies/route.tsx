import { createFileRoute, Outlet } from "@tanstack/react-router";

// Este archivo define la ruta base para la sección de compañías
export const Route = createFileRoute("/$companyId/companies")({
  // Este componente actúa como un layout para todas las rutas de companies
  component: () => {
    // Es crucial usar Outlet para renderizar las rutas hijas
    return <Outlet />;
  },
});
