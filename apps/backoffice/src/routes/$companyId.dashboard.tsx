import { createFileRoute } from "@tanstack/react-router";

import { DashboardPage } from "../sections/dashboard/pages/DashboardPage";

// La ruta del dashboard - la protección se maneja en el componente Dashboard
export const Route = createFileRoute("/$companyId/dashboard")({
  component: DashboardPage,
});
