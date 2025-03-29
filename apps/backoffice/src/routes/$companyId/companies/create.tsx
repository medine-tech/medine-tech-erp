import { createFileRoute } from "@tanstack/react-router";
import { lazy } from "react";

// Usando importación dinámica para resolver problemas de resolución de módulos
const CompanyFormPage = lazy(() =>
  import("../../../sections/companies/pages/CompanyFormPage").then((module) => ({
    default: module.CompanyFormPage,
  })),
);

export const Route = createFileRoute("/$companyId/companies/create")({
  component: CompanyFormPage,
});
