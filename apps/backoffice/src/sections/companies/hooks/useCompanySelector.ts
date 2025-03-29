import { useEffect, useState } from "react";

import { ApiError, authService } from "../../auth/services/auth";
import { Company } from "../services/company";

export function useCompanySelector(currentCompanyId: string): {
  companies: Company[];
  currentCompany: Company | null;
  isLoading: boolean;
  error: ApiError | null;
} {
  const [companies, setCompanies] = useState<Company[]>([]);
  const [currentCompany, setCurrentCompany] = useState<Company | null>(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<ApiError | null>(null);

  useEffect(() => {
    let isMounted = true;

    async function loadCompanies() {
      if (isLoading) {
        return;
      }

      setIsLoading(true);

      try {
        const response = await authService.getCompanies();

        if (isMounted) {
          setCompanies(response.items);

          const company = response.items.find(
            (company: Company) => company.id === currentCompanyId,
          );
          if (company) {
            setCurrentCompany(company);
          }

          setIsLoading(false);
        }
      } catch (err) {
        if (isMounted) {
          setError(err as ApiError);
          setIsLoading(false);
        }
      }
    }

    void loadCompanies();

    return () => {
      isMounted = false;
    };
  }, [currentCompanyId]);

  return {
    companies,
    currentCompany,
    isLoading,
    error,
  };
}
