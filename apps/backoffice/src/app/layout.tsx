import type { Metadata } from "next";
import { Inter } from "next/font/google";
import type React from "react";
import { Toaster } from "sonner";

import "@/styles/globals.css";

const inter = Inter({ subsets: ["latin"] });

export const metadata: Metadata = {
  title: "MedineTech ERP - Sistema de Gestión Empresarial",
  description:
    "Sistema ERP integral para pequeñas y medianas empresas. Optimiza tus operaciones empresariales con nuestra solución de gestión.",
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="es" className="scroll-smooth" suppressHydrationWarning>
      <body className={inter.className}>
        {children}
        <Toaster position="top-right" />
      </body>
    </html>
  );
}
