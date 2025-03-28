import { createRootRoute, Outlet } from "@tanstack/react-router";

import { Toaster } from "../components/ui/sonner";

// Definimos la ruta raíz sin contexto por ahora
export const Route = createRootRoute({
  component: () => (
    <>
      <Outlet />
      <Toaster position="top-right" richColors closeButton />
    </>
  ),
});
