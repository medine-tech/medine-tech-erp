import { Users } from "lucide-react"
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle
} from "@/app/components/ui/card"

interface Company {
    id: number
    name: string
    employees: number
}

interface CompanyListProps {
    companies: Company[]
}

export function CompanyList({ companies }: CompanyListProps) {
    return (
        <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            {companies.map((company) => (
                <Card key={company.id} className="hover:bg-muted/50 transition-colors">
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-lg font-medium">{company.name}</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid gap-2">
                            <div className="flex items-center text-sm text-muted-foreground">
                                <Users className="mr-2 h-4 w-4" />
                                {company.employees} employees
                            </div>
                        </div>
                    </CardContent>
                </Card>
            ))}
        </div>
    )
}

