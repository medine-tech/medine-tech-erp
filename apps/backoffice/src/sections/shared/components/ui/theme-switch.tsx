import { Moon, Sun, Laptop } from "lucide-react";
import { useTheme } from "../../context/ThemeContext";

export function ThemeSwitch() {
  const { theme, setTheme } = useTheme();

  // Calcular la posición del indicador basado en el tema actual
  const getIndicatorPosition = () => {
    switch (theme) {
      case "light":
        return "left-0";
      case "system":
        return "left-[calc(50%-16px)]";
      case "dark":
        return "right-0";
      default:
        return "left-[calc(50%-16px)]";
    }
  };

  return (
    <div className="p-0.5 rounded-full bg-card/80 backdrop-blur-sm border border-border/30 shadow-sm hover:shadow-md transition-all duration-300">
      <div className="flex items-center justify-between p-0.5 relative">
        {/* Indicador activo con posicionamiento absoluto mejorado */}
        <div 
          className={`absolute ${getIndicatorPosition()} w-1/3 h-full rounded-full bg-primary/20 transition-all duration-300 ease-in-out`} 
        />
        
        <button
          onClick={() => setTheme("light")}
          className={`relative z-10 rounded-full p-1.5 transition-colors duration-300 flex items-center justify-center flex-1
            ${theme === "light" ? "text-primary" : "text-muted-foreground hover:text-foreground"}`}
          title="Modo Claro"
        >
          <Sun className="h-4 w-4" strokeWidth={theme === "light" ? 2.5 : 1.5} />
          <span className="sr-only">Modo Claro</span>
        </button>
        
        <button
          onClick={() => setTheme("system")}
          className={`relative z-10 rounded-full p-1.5 transition-colors duration-300 flex items-center justify-center flex-1
            ${theme === "system" ? "text-primary" : "text-muted-foreground hover:text-foreground"}`}
          title="Usar configuración del sistema"
        >
          <Laptop className="h-4 w-4" strokeWidth={theme === "system" ? 2.5 : 1.5} />
          <span className="sr-only">Usar configuración del sistema</span>
        </button>
        
        <button
          onClick={() => setTheme("dark")}
          className={`relative z-10 rounded-full p-1.5 transition-colors duration-300 flex items-center justify-center flex-1
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
