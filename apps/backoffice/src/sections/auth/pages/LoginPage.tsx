import { useNavigate } from "@tanstack/react-router";
import { useEffect } from "react";

import medineLogoSrc from "../../../assets/medine-logo.svg";
import { Link } from "../../shared/components/Link";
import { LoginForm } from "../components/LoginForm";
import { useAuth } from "../context/AuthContext";
import { authService } from "../services/auth";

export function LoginPage() {
  const { isAuthenticated } = useAuth();
  const navigate = useNavigate();

  const searchParams = new URLSearchParams(window.location.search);
  const returnTo = searchParams.get("returnTo");

  useEffect(() => {
    if (isAuthenticated) {
      if (returnTo) {
        window.location.href = returnTo;

        return;
      }

      const defaultCompanyId = authService.getDefaultCompanyId() || "";
      void navigate({ to: "/$companyId/dashboard", params: { companyId: defaultCompanyId } });
    }
  }, [isAuthenticated, navigate, returnTo]);

  const handleLoginSuccess = () => {
    if (returnTo) {
      window.location.href = returnTo;

      return;
    }

    const defaultCompanyId = authService.getDefaultCompanyId() || "";
    void navigate({ to: "/$companyId/dashboard", params: { companyId: defaultCompanyId } });
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-slate-800 to-slate-900 flex flex-col">
      <header className="bg-slate-900/80 backdrop-blur-sm text-white py-4 px-6 shadow-md">
        <div className="container mx-auto">
          <Link to="/" className="flex items-center gap-2 w-fit">
            <img src={medineLogoSrc} alt="Medine Logo" className="h-8 w-auto" />
            <span className="text-xl font-bold">MEDINE</span>
          </Link>
        </div>
      </header>

      <main className="flex-grow flex items-center justify-center p-4">
        <div className="w-full max-w-md">
          <LoginForm onSuccess={handleLoginSuccess} />
        </div>
      </main>

      <footer className="bg-slate-900/80 text-white py-4 text-center text-sm">
        <div className="container mx-auto">
          <p>&copy; {new Date().getFullYear()} Medine Technology. Todos los derechos reservados.</p>
        </div>
      </footer>
    </div>
  );
}

export default LoginPage;
