import { createFileRoute } from "@tanstack/react-router";

import { CompanyFormPage } from "../../../sections/companies/pages/CompanyFormPage";

export const Route = createFileRoute("/$companyId/companies/create")({
  component: CompanyFormPage,
});
