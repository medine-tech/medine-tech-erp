import { createFileRoute } from "@tanstack/react-router";

import { DashboardPage } from "../../sections/dashboard/pages/DashboardPage";

export const Route = createFileRoute("/$companyId/dashboard")({
  component: DashboardPage,
});
