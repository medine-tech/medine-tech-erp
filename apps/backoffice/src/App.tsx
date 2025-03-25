import { BrowserRouter as Router, Route, Routes } from "react-router-dom";

import { ProtectedRoute } from "./components/ProtectedRoute";
import { Toaster } from "./components/ui/sonner";
import { AuthProvider } from "./lib/context/AuthContext";
import { Dashboard } from "./pages/Dashboard";
import { FirstCompanyRegister } from "./pages/FirstCompanyRegister";
import { Login } from "./pages/Login";
import { LandingPage } from "./LandingPage";

function App() {
  return (
    <AuthProvider>
      <Router>
          <Routes>
              {/* Rutas públicas */}
              <Route path="/" element={<LandingPage />} />
              <Route path="/login" element={<Login />} />
              <Route path="/register" element={<FirstCompanyRegister />} />

              {/* Rutas protegidas */}
              <Route
                  path="/:companyId/dashboard"
                  element={
                      <ProtectedRoute>
                          <Dashboard />
                      </ProtectedRoute>
                  }
              />

              {/* Ruta de fallback */}
              <Route path="*" element={<LandingPage />} />
          </Routes>
          <Toaster position="top-right" richColors closeButton />
      </Router>
    </AuthProvider>
  );
}

export default App;
