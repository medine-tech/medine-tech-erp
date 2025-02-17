"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { getAuthToken, logout } from "@/app/actions/auth";
import toast from "react-hot-toast";

export default function DashboardPage() {
    const router = useRouter();
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        async function checkAuth() {
            const token = await getAuthToken();
            if (!token) {
                toast.error("Debes iniciar sesión primero.");
                router.push("/login");
            } else {
                setLoading(false);
            }
        }

        checkAuth();
    }, [router]);

    const handleLogout = async () => {
        await logout();
        toast.success("Has cerrado sesión correctamente");
        router.push("/login");
    };

    if (loading) {
        return (
            <div className={"items-center font-extrabold text-gray-900"}>
                <p>Cargando...</p>
            </div>
        );
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">
            <div className="p-8">
                <h1 className="text-2xl font-bold font-extrabold text-gray-900">Dashboard</h1>
                <button
                    onClick={handleLogout}
                    className="mt-4 px-4 py-2 bg-red-500 text-white rounded"
                >
                    Cerrar sesión
                </button>
            </div>
        </div>
    );
}
