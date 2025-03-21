import { getCompanies } from "@/app/actions/companies";
import { Card, CardHeader, CardTitle } from "@/components/ui/card";

interface Company {
  id: string;
  created_at: string;
  updated_at: string;
  pivot: {
    user_id: number;
    company_id: string;
  };
}

export async function CompanyList() {
  const companiesData = await getCompanies();
  const companiesList: Company[] = companiesData.data.data || [];

  return (
    <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
      {companiesList.map((company) => (
        <Card key={company.id} className="hover:bg-muted/50 transition-colors">
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-lg font-medium">{company.pivot.company_id}</CardTitle>
          </CardHeader>
        </Card>
      ))}
    </div>
  );
}
