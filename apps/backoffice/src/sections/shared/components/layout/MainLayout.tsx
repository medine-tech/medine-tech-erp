import { Outlet } from "@tanstack/react-router";
import React from "react";
import { ThemeSwitch } from "../ui/theme-switch";

export function MainLayout({ children }: { children?: React.ReactNode }) {
  return (
    <div className="min-h-screen bg-background">
      <div className="flex h-screen overflow-hidden">
        {/* Sidebar moderna y elegante */}
        <div className="hidden md:flex flex-col w-72 bg-sidebar border-r border-sidebar-border shadow-lg transition-all duration-300">
          <div className="p-5 border-b border-sidebar-border flex items-center space-x-3">
            <div className="bg-sidebar-primary h-8 w-8 rounded-md flex items-center justify-center">
              <span className="text-sidebar-primary-foreground font-bold text-lg">M</span>
            </div>
            <h1 className="text-xl font-bold text-sidebar-foreground">Medine Tech ERP</h1>
          </div>
          <nav className="flex-1 py-5 px-4 overflow-y-auto">
            {/* Menú de navegación */}
            <div className="mb-4 px-2 text-xs font-semibold text-sidebar-foreground/60 uppercase tracking-wider">
              Principal
            </div>
            <ul className="space-y-1.5">
              <li>
                <a 
                  href="/dashboard" 
                  className="flex items-center p-2.5 rounded-lg text-sidebar-foreground hover:bg-sidebar-accent/20 hover:text-sidebar-primary
                           group transition-colors duration-200"
                >
                  <div className="mr-3 h-5 w-5 rounded-md bg-sidebar-primary/20 flex items-center justify-center group-hover:bg-sidebar-primary/40 transition-colors duration-200">
                    <span className="text-xs">D</span>
                  </div>
                  <span>Panel Principal</span>
                </a>
              </li>
              <li>
                <a 
                  href="/companies" 
                  className="flex items-center p-2.5 rounded-lg text-sidebar-foreground hover:bg-sidebar-accent/20 hover:text-sidebar-primary
                           group transition-colors duration-200"
                >
                  <div className="mr-3 h-5 w-5 rounded-md bg-sidebar-primary/20 flex items-center justify-center group-hover:bg-sidebar-primary/40 transition-colors duration-200">
                    <span className="text-xs">E</span>
                  </div>
                  <span>Empresas</span>
                </a>
              </li>
              <li>
                <a 
                  href="/accounting" 
                  className="flex items-center p-2.5 rounded-lg text-sidebar-foreground hover:bg-sidebar-accent/20 hover:text-sidebar-primary
                           group transition-colors duration-200"
                >
                  <div className="mr-3 h-5 w-5 rounded-md bg-sidebar-primary/20 flex items-center justify-center group-hover:bg-sidebar-primary/40 transition-colors duration-200">
                    <span className="text-xs">C</span>
                  </div>
                  <span>Contabilidad</span>
                </a>
              </li>
              <li>
                <a 
                  href="/inventory" 
                  className="flex items-center p-2.5 rounded-lg text-sidebar-foreground hover:bg-sidebar-accent/20 hover:text-sidebar-primary
                           group transition-colors duration-200"
                >
                  <div className="mr-3 h-5 w-5 rounded-md bg-sidebar-primary/20 flex items-center justify-center group-hover:bg-sidebar-primary/40 transition-colors duration-200">
                    <span className="text-xs">I</span>
                  </div>
                  <span>Inventario</span>
                </a>
              </li>
              <li>
                <a 
                  href="/users" 
                  className="flex items-center p-2.5 rounded-lg text-sidebar-foreground hover:bg-sidebar-accent/20 hover:text-sidebar-primary
                           group transition-colors duration-200"
                >
                  <div className="mr-3 h-5 w-5 rounded-md bg-sidebar-primary/20 flex items-center justify-center group-hover:bg-sidebar-primary/40 transition-colors duration-200">
                    <span className="text-xs">U</span>
                  </div>
                  <span>Usuarios</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        {/* Contenido principal */}
        <div className="flex-1 flex flex-col overflow-hidden">
          <header className="h-16 border-b border-border/40 flex items-center px-6 justify-between bg-card/50 backdrop-blur-sm">
            <div>
              {/* Botón para menú móvil con mejor diseño */}
              <button className="md:hidden p-1.5 rounded-md hover:bg-primary/10 transition-colors">
                <span className="text-foreground">☰</span>
              </button>
            </div>
            <div className="flex items-center space-x-4">
              <ThemeSwitch />
              <div className="flex items-center space-x-2 px-3 py-1.5 rounded-full bg-card hover:bg-accent/10 transition-all cursor-pointer">
                <span className="text-sm font-medium">Usuario</span>
                <div className="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center text-primary-foreground font-medium text-sm">U</div>
              </div>
            </div>
          </header>

          <main className="flex-1 p-6 overflow-auto">{children ?? <Outlet />}</main>
        </div>
      </div>
    </div>
  );
}
