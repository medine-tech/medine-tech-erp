import { createRouter, RouterProvider } from "@tanstack/react-router";

import { routeTree } from "../routeTree.gen";

import { useAuth } from "./context/AuthContext";

// Definimos las interfaces necesarias para la autenticación
export interface AuthContext {
  isAuthenticated: boolean;
  loading: boolean;
}

// Declaración de tipo para el router de TanStack
declare module "@tanstack/react-router" {
  interface Register {
    router: typeof router;
  }
}

// Creamos el router con la configuración básica
export const router = createRouter({
  routeTree,
  // No inicializamos el contexto aquí, lo haremos en el RouterProvider
});

// Componente proveedor de rutas con contexto de autenticación
export function RouterWithAuth() {
  // Obtenemos los datos de autenticación del contexto
  const auth = useAuth();

  return <RouterProvider router={router} context={{ auth }} />;
}
