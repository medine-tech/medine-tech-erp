import { useParams } from "@tanstack/react-router";

export function DashboardPage() {
  const { companyId } = useParams({ from: "/$companyId/dashboard" });

  return (
    <>
      <h2 className="text-2xl font-bold mb-6">Panel de control</h2>
      <div className="bg-card shadow-md rounded-lg p-6">
        <p className="text-muted-foreground mb-4">
          Bienvenido al panel de control de Medine. Esta es una página de ejemplo.
        </p>
        <p className="text-sm text-muted-foreground">ID de Compañía: {companyId}</p>
      </div>
    </>
  );
}

export default DashboardPage;
