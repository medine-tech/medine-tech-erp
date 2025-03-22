import { useParams } from "react-router-dom";

export function Dashboard() {
  const { companyId } = useParams<{ companyId: string }>();

  return (
    <div className="min-h-screen bg-slate-100">
      <div className="container mx-auto py-8 px-4">
        <h1 className="text-2xl font-bold mb-6">Panel de control</h1>
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
