"use client";

import { useEffect } from "react";
import { useRouter } from "next/navigation";
import { getAuthToken, logout } from "@/app/actions/auth";

export default function DashboardPage() {
    const router = useRouter();

    useEffect(() => {
        async function checkAuth() {
            try {
                const token = await getAuthToken();
                if (!token) {
                    router.push("/login");
                }
            } catch (error) {
                console.error("Error checking auth:", error);
            }
        }

        checkAuth();
    }, [router]);

    const handleLogout = async () => {
        await logout();
        router.push("/login");
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">
            <div className="p-8">
                <h1 className="text-2xl font-bold font-extrabold text-gray-900">Dashboard</h1>
                <button
                    onClick={handleLogout}
                    className="mt-4 px-4 py-2 bg-red-500 text-white rounded"
                    aria-label="Cerrar sesión"
                >
                    Cerrar sesión
                </button>
            </div>
        </div>
    );
}
