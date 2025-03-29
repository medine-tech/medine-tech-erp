import { createRouter, RouterProvider } from "@tanstack/react-router";

import { routeTree } from "../../../routeTree.gen";
import { useAuth } from "../../auth/context/AuthContext";

export interface AuthContext {
  isAuthenticated: boolean;
  loading: boolean;
}

declare module "@tanstack/react-router" {
  interface Register {
    router: typeof router;
  }
}

export const router = createRouter({
  routeTree,
});

export function RouterWithAuth() {
  const auth = useAuth();

  return <RouterProvider router={router} context={{ auth }} />;
}
