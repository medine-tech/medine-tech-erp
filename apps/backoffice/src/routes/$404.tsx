import { createFileRoute } from "@tanstack/react-router";

import { LandingPage } from "../sections/home/pages/LandingPage";

export const Route = createFileRoute("/$404")({
  component: LandingPage,
});
