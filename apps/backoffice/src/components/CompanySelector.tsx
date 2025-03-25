// Componente selector de empresas
import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

import { useCompany } from "../lib/context/CompanyContext";

import { LoadingSpinner } from "./ui/LoadingSpinner";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "./ui/select";

export function CompanySelector() {
  const { companies, loading, error, switchCompany, refreshCompanies } = useCompany();
  const { companyId } = useParams<{ companyId: string }>();
  const [selectedCompany, setSelectedCompany] = useState<string | null>(null);

  // Actualizar la empresa seleccionada cuando cambia el ID en la URL
  useEffect(() => {
    if (companyId) {
      setSelectedCompany(companyId);
    }
  }, [companyId]);

  // Intentar cargar las empresas nuevamente si hay un error
  useEffect(() => {
    if (error && !loading && companies.length === 0) {
      const timer = setTimeout(() => {
        void refreshCompanies();
      }, 5000); // Reintentar cada 5 segundos

      return () => clearTimeout(timer);
    }
  }, [error, loading, companies.length, refreshCompanies]);

  const handleCompanyChange = (companyId: string) => {
    void switchCompany(companyId);
  };

  if (loading) {
    return (
      <div className="flex items-center space-x-2 py-2">
        <LoadingSpinner size="small" />
        <span className="text-sm text-slate-600">Cargando empresas...</span>
      </div>
    );
  }

  if (error && !companies.length) {
    return (
      <div className="text-sm text-red-600 py-2 flex flex-col space-y-2">
        <p>Error al cargar empresas</p>
        <button
          onClick={() => void refreshCompanies()}
          className="text-xs text-blue-600 hover:text-blue-800 underline"
        >
          Reintentar
        </button>
      </div>
    );
  }

  if (!companies.length) {
    return (
      <div className="text-sm text-slate-600 py-2 flex flex-col space-y-2">
        <p>No hay empresas disponibles</p>
        <button
          onClick={() => void refreshCompanies()}
          className="text-xs text-blue-600 hover:text-blue-800 underline"
        >
          Reintentar
        </button>
        <p className="text-xs text-gray-500">
          Verifica que estés autenticado y tengas acceso a empresas en el sistema.
        </p>
      </div>
    );
  }

  return (
    <div className="w-full">
      <label className="block text-sm font-medium text-slate-700 mb-1">Empresa actual</label>
      <Select value={selectedCompany ?? ""} onValueChange={handleCompanyChange}>
        <SelectTrigger className="w-full">
          <SelectValue placeholder="Seleccionar empresa" />
        </SelectTrigger>
        <SelectContent>
          {companies.map((company) => (
            <SelectItem key={company.id} value={company.id}>
              {company.name}
            </SelectItem>
          ))}
        </SelectContent>
      </Select>
    </div>
  );
}
