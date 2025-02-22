import { CompanyList } from "@/app/components/ui/dashboard/company-list";
import { DashboardHeader } from "@/app/components/ui/dashboard/dashboard-header";

export default async function DashboardPage() {
	return (
		<div className="flex min-h-screen flex-col">
			<DashboardHeader />
			<main className="flex-1 space-y-4 p-8 pt-6">
				<div className="flex items-center justify-between">
					<h2 className="text-3xl font-bold tracking-tight">Tus Empresas</h2>
				</div>
				<CompanyList />
			</main>
		</div>
	);
}
