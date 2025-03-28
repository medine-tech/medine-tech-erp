import { createFileRoute } from "@tanstack/react-router";

import { FirstCompanyRegister } from "../pages/FirstCompanyRegister";

export const Route = createFileRoute("/register")({
  component: FirstCompanyRegister,
});
