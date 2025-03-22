import { useParams, useNavigate } from "react-router-dom";
import { Button } from "../components/ui/button";
import { authService } from "../lib/services/auth";

export function Dashboard() {
  const { companyId } = useParams<{ companyId: string }>();
  const navigate = useNavigate();

  const handleLogout = async () => {
    try {
      await authService.logout();
      navigate("/login");
    } catch (error) {
      console.error("Error al cerrar sesión:", error);
    }
  };

  return (
    <div className="min-h-screen bg-slate-100">
      {/* Header con botón de logout */}
      <header className="bg-white shadow-sm border-b border-slate-200">
        <div className="container mx-auto px-4 py-4 flex justify-between items-center">
          <h1 className="text-xl font-medium text-slate-800">Medine Tech</h1>
          <Button 
            variant="outline" 
            className="flex items-center gap-2 text-slate-700 hover:text-slate-900"
            onClick={handleLogout}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              strokeWidth="2"
              strokeLinecap="round"
              strokeLinejoin="round"
            >
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
              <polyline points="16 17 21 12 16 7" />
              <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Cerrar sesión
          </Button>
        </div>
      </header>

      {/* Contenido principal */}
      <div className="container mx-auto py-8 px-4">
        <h2 className="text-2xl font-bold mb-6">Panel de control</h2>
        <div className="bg-white shadow-md rounded-lg p-6">
          <p className="text-gray-700 mb-4">
            Bienvenido al panel de control de Medine. Esta es una página de ejemplo.
          </p>
          <p className="text-sm text-gray-600">ID de Compañía: {companyId}</p>
        </div>
      </div>
    </div>
  );
}
