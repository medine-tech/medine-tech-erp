import { BrowserRouter as Router, Route, Routes } from "react-router-dom";

import { ProtectedRoute } from "./components/ProtectedRoute";
import { AuthProvider } from "./lib/context/AuthContext";
import { Toaster } from "./components/ui/sonner";
import { LandingPage } from "./LandingPage";
import { Login } from "./pages/Login";
import { FirstCompanyRegister } from "./pages/FirstCompanyRegister";
import { Dashboard } from "./pages/Dashboard";

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
          <Route path="/:companyId/dashboard" element={
            <ProtectedRoute>
              <Dashboard />
            </ProtectedRoute>
          } />
          
          {/* Ruta de fallback */}
          <Route path="*" element={<LandingPage />} />
        </Routes>
        <Toaster position="top-right" richColors closeButton />
      </Router>
    </AuthProvider>
  );
}

export default App;
