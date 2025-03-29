import { Moon, Sun, Laptop } from "lucide-react";
import { useTheme } from "../../context/ThemeContext";

export function ThemeSwitch() {
  const { theme, setTheme } = useTheme();

  return (
    <div className="p-0.5 rounded-full bg-card/80 backdrop-blur-sm border border-border/30 shadow-sm hover:shadow-md transition-all duration-300">
      <div className="flex items-center p-0.5 relative">
        {/* Indicador activo */}
        <div 
          className={`absolute inset-0 w-1/3 h-full rounded-full bg-primary/20 transform transition-transform duration-300 ease-in-out
                      ${theme === "light" ? "translate-x-0" : theme === "dark" ? "translate-x-full" : "translate-x-1/2"}`} 
        />
        
        <button
          onClick={() => setTheme("light")}
          className={`relative z-10 rounded-full p-1.5 transition-colors duration-300 flex items-center justify-center
            ${theme === "light" ? "text-primary" : "text-muted-foreground hover:text-foreground"}`}
          title="Modo Claro"
        >
          <Sun className="h-4 w-4" strokeWidth={theme === "light" ? 2.5 : 1.5} />
          <span className="sr-only">Modo Claro</span>
        </button>
        
        <button
          onClick={() => setTheme("system")}
          className={`relative z-10 rounded-full p-1.5 transition-colors duration-300 flex items-center justify-center
            ${theme === "system" ? "text-primary" : "text-muted-foreground hover:text-foreground"}`}
          title="Usar configuración del sistema"
        >
          <Laptop className="h-4 w-4" strokeWidth={theme === "system" ? 2.5 : 1.5} />
          <span className="sr-only">Usar configuración del sistema</span>
        </button>
        
        <button
          onClick={() => setTheme("dark")}
          className={`relative z-10 rounded-full p-1.5 transition-colors duration-300 flex items-center justify-center
            ${theme === "dark" ? "text-primary" : "text-muted-foreground hover:text-foreground"}`}
          title="Modo Oscuro"
        >
          <Moon className="h-4 w-4" strokeWidth={theme === "dark" ? 2.5 : 1.5} />
          <span className="sr-only">Modo Oscuro</span>
        </button>
      </div>
    </div>
  );
}
