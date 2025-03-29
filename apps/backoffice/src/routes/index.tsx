import { createFileRoute } from "@tanstack/react-router";

import { LandingPage } from "../sections/home/pages";

export const Route = createFileRoute("/")({
  component: LandingPage,
});
