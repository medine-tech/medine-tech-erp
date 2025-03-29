import { createFileRoute } from "@tanstack/react-router";

import { LandingPage } from "../sections/home/pages/LandingPage.tsx";

export const Route = createFileRoute("/")({
  component: LandingPage,
});
