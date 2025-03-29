import { createFileRoute, Outlet } from "@tanstack/react-router";

// Este archivo define la ruta base para las rutas con ID de compañía
export const Route = createFileRoute("/$companyId")({
  component: () => {
    // Es importante usar Outlet para renderizar las rutas hijas
    return <Outlet />;
  },
});
