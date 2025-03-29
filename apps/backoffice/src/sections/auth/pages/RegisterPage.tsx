import { useNavigate } from "@tanstack/react-router";

import medineLogoSrc from "../../../assets/medine-logo.svg";
import { Link } from "../../shared/components/Link";
import { RegisterForm } from "../components/RegisterForm";

export function RegisterPage() {
  const navigate = useNavigate();

  const handleRegisterSuccess = () => {
    void navigate({ to: "/login" });
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
          <RegisterForm onSuccess={handleRegisterSuccess} />
        </div>
      </main>

      <footer className="bg-slate-900/80 backdrop-blur-sm text-white py-4 px-6">
        <div className="container mx-auto text-center text-sm text-slate-400">
          &copy; {new Date().getFullYear()} Medine Tech. Todos los derechos reservados.
        </div>
      </footer>
    </div>
  );
}

export default RegisterPage;
