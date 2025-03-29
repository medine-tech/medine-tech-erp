import { Outlet } from "@tanstack/react-router";
import React from "react";

export function MainLayout({ children }: { children?: React.ReactNode }) {
  return (
    <div className="min-h-screen bg-background">
      <div className="flex">
        {/* Sidebar */}
        <div className="hidden md:flex flex-col w-64 border-r bg-card">
          <div className="p-4 border-b">
            <h1 className="text-xl font-bold">Medine Tech ERP</h1>
          </div>
          <nav className="flex-1 p-4">
            {/* Menú de navegación */}
            <ul className="space-y-2">
              <li>
                <a href="/dashboard" className="flex items-center p-2 rounded-md hover:bg-accent">
                  <span className="ml-2">Panel Principal</span>
                </a>
              </li>
              <li>
                <a href="/companies" className="flex items-center p-2 rounded-md hover:bg-accent">
                  <span className="ml-2">Empresas</span>
                </a>
              </li>
              <li>
                <a href="/accounting" className="flex items-center p-2 rounded-md hover:bg-accent">
                  <span className="ml-2">Contabilidad</span>
                </a>
              </li>
              <li>
                <a href="/inventory" className="flex items-center p-2 rounded-md hover:bg-accent">
                  <span className="ml-2">Inventario</span>
                </a>
              </li>
              <li>
                <a href="/users" className="flex items-center p-2 rounded-md hover:bg-accent">
                  <span className="ml-2">Usuarios</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        {/* Contenido principal */}
        <div className="flex-1">
          <header className="h-16 border-b flex items-center px-6 justify-between bg-card">
            <div>
              {/* Botón para menú móvil */}
              <button className="md:hidden">
                <span>☰</span>
              </button>
            </div>
            <div className="flex items-center space-x-4">
              <span>Usuario</span>
              <div className="h-8 w-8 rounded-full bg-primary" />
            </div>
          </header>

          <main className="p-6">{children ?? <Outlet />}</main>
        </div>
      </div>
    </div>
  );
}
