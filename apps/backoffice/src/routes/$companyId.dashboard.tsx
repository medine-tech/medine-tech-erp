import { createFileRoute } from "@tanstack/react-router";

import { Dashboard } from "../pages/Dashboard";

// La ruta del dashboard - la protección se maneja en el componente Dashboard
export const Route = createFileRoute("/$companyId/dashboard")({
  component: Dashboard,
});
