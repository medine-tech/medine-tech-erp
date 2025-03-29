import { createFileRoute } from "@tanstack/react-router";
import { UserFormPage } from "../../../../sections/users/pages/UserFormPage";

export const Route = createFileRoute("/$companyId/users/edit/$id")({
  component: UserFormPage,
});
