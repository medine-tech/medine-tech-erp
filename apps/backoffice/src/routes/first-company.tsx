import { createFileRoute } from "@tanstack/react-router";

import { FirstCompanyRegisterPage } from "../sections/companies/pages";

export const Route = createFileRoute("/first-company")({
  component: FirstCompanyRegisterPage,
});
