import { LogOut } from "lucide-react"
import Link from "next/link"
import { useRouter } from "next/navigation";
import { logout } from "@/app/actions/auth";
import { Button } from "@/app/components/ui/button";

export function DashboardHeader() {
    const router = useRouter();

    const handleLogout = async () => {
        await logout();
        router.push("/login");
    };

    return (
        <header className="border-b bg-white">
            <div className="flex h-16 items-center px-4">
                <Link href="/dashboard" className="font-semibold">
                    Dashboard
                </Link>
                <div className="ml-auto flex items-center space-x-4">
                    <Button
                        onClick={handleLogout}
                        variant="ghost" size="sm">
                        <LogOut className="h-4 w-4 mr-2"/>
                        Cerrar sesión
                    </Button>
                </div>
            </div>
        </header>
    )
}
