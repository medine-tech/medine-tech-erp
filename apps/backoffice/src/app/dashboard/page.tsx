"use client";


import { CompanyList } from "@/app/components/ui/dashboard/company-list";
import { DashboardHeader } from "@/app/components/ui/dashboard/dashboard-header";

// This would normally come from your database/API
const mockCompanies = [
    {
        id: 1,
        name: "Acme Inc",
        employees: 150,
    },
    {
        id: 2,
        name: "Global Corp",
        employees: 500,
    },
    {
        id: 3,
        name: "Tech Solutions",
        employees: 75,
    },
]

export default function DashboardPage() {

    return (
        <div className="flex min-h-screen flex-col">
            <DashboardHeader />
            <main className="flex-1 space-y-4 p-8 pt-6">
                <div className="flex items-center justify-between">
                    <h2 className="text-3xl font-bold tracking-tight">Your Companies</h2>
                </div>
                <CompanyList companies={mockCompanies} />
            </main>
        </div>
    )
}
