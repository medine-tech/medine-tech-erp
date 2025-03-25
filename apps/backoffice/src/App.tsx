import { BrowserRouter as Router, Navigate, Route, Routes } from "react-router-dom";

import { LandingPage } from "./LandingPage";
import { ProtectedRoute } from "./components/ProtectedRoute";
import { Toaster } from "./components/ui/sonner";
import { AuthProvider } from "./lib/context/AuthContext";
import { CompanyProvider } from "./lib/context/CompanyContext";
import { Dashboard } from "./pages/Dashboard";
import { FirstCompanyRegister } from "./pages/FirstCompanyRegister";
import { Login } from "./pages/Login";

// Componente para manejar la redirección después del inicio de sesión
function RedirectAfterLogin() {
  // Obtener el ID de empresa para redirección
  const redirectCompanyId =
    sessionStorage.getItem("redirect_company_id") ??
    localStorage.getItem("currentCompanyId") ??
    localStorage.getItem("default_company_id") ??
    sessionStorage.getItem("default_company_id");

  if (redirectCompanyId) {
    // Limpiar el ID de empresa de redirección (pero mantener los otros)
    sessionStorage.removeItem("redirect_company_id");

    // Redirigir al dashboard con la empresa seleccionada
    return <Navigate to={`/${redirectCompanyId}/dashboard`} replace />;
  }

  // Si no hay ID de empresa guardado, redirigir a la página de inicio
  return <Navigate to="/" replace />;
}

function App() {
  return (
    <AuthProvider>
      <Router>
        <CompanyProvider>
          <Routes>
            {/* Ruta para manejar la redirección después del inicio de sesión */}
            <Route path="/redirect" element={<RedirectAfterLogin />} />
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
        </CompanyProvider>
      </Router>
    </AuthProvider>
  );
}

export default App;
