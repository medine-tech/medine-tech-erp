import { createRouter, RouterProvider } from "@tanstack/react-router";

import { routeTree } from "../routeTree.gen";

import { useAuth } from "./context/AuthContext";

export const router = createRouter({
  routeTree,
});

// Registramos el router para TypeScript
declare module "@tanstack/react-router" {
  interface Register {
    router: typeof router;
  }
}

// Componente proveedor de rutas con contexto de autenticación
export function RouterWithAuth() {
  // Obtenemos los datos de autenticación del contexto
  const auth = useAuth();

  return <RouterProvider router={router} context={{ auth }} />;
}
