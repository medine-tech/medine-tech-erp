import { createFileRoute } from "@tanstack/react-router";

// Importación directa del componente para evitar problemas con TypeScript
import { CompanyFormPage } from "../../../sections/companies/pages/CompanyFormPage";

export const Route = createFileRoute("/$companyId/companies/create")({
  component: CompanyFormPage,
});
