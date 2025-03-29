import { createFileRoute } from "@tanstack/react-router";

import { RegisterPage } from "../sections/auth/pages";

export const Route = createFileRoute("/register")({
  component: RegisterPage,
});
