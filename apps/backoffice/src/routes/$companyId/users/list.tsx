import { createFileRoute } from "@tanstack/react-router";
import { UsersListPage } from "../../../sections/users/pages/UsersListPage";

export const Route = createFileRoute("/$companyId/users/list")({
  component: UsersListPage,
});
