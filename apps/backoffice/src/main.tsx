import { StrictMode } from "react";
import { createRoot } from "react-dom/client";

import App from "./App.tsx";

import "./index.css";

const rootElement = document.getElementById("root");

if (rootElement) {
  createRoot(rootElement).render(
    <StrictMode>
      <App />
    </StrictMode>,
  );
} else {
  // Unable to find root element - show fallback error UI
  document.body.innerHTML =
    "<div style='color:red;padding:20px'>Failed to initialize application: Root element not found</div>";
}
