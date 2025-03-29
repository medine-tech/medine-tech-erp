import { createRootRoute, Outlet } from "@tanstack/react-router";

import { Toaster } from "../sections/shared/components/ui/sonner";

export const Route = createRootRoute({
  component: () => (
    <>
      <Outlet />
      <Toaster position="top-right" richColors closeButton />
    </>
  ),
});
