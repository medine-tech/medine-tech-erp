import { createFileRoute } from "@tanstack/react-router";

import { ProtectedLayout } from "../../sections/shared/layouts/ProtectedLayout";

// Este archivo define la ruta base para las rutas con ID de compañía
export const Route = createFileRoute("/$companyId")({
  component: ProtectedLayout,
});
