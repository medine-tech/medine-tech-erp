import { createFileRoute } from "@tanstack/react-router";

import { LoginPage } from "../sections/auth/pages";

export const Route = createFileRoute("/login")({
  component: LoginPage,
});
