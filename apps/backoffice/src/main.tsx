import { StrictMode } from "react";
import { createRoot } from "react-dom/client";

import { ThemeProvider } from "./sections/shared/context/ThemeContext";
import App from "./App.tsx";

import "./index.css";

const rootElement = document.getElementById("root");

if (rootElement) {
  createRoot(rootElement).render(
    <StrictMode>
      <ThemeProvider defaultTheme="system" storageKey="medine-theme-preference">
        <App />
      </ThemeProvider>
    </StrictMode>,
  );
} else {
  document.body.innerHTML =
    "<div style='color:red;padding:20px'>Error al inicializar la aplicación: Elemento root no encontrado</div>";
}
