import { createFileRoute } from "@tanstack/react-router";

import { CompaniesListPage } from "../../../sections/companies/pages/CompaniesListPage";

export const Route = createFileRoute("/$companyId/companies/list")({
  component: CompaniesListPage,
});
