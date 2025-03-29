import medineLogoSrc from "../../../assets/medine-logo.svg";
import { Link } from "../../shared/components/Link";
import { Button } from "../../shared/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "../../shared/components/ui/card";
import { ThemeSwitch } from "../../shared/components/ui/theme-switch";

export function LandingPage() {
  return (
    <div className="min-h-screen flex flex-col bg-background">
      {/* Header */}
      <header className="bg-primary/90 dark:bg-slate-900 text-primary-foreground py-4 px-6 shadow-md">
        <div className="container mx-auto flex justify-between items-center">
          <div className="flex items-center gap-2">
            <img src={medineLogoSrc} alt="Medine Logo" className="h-10 w-auto" />
            <span className="text-xl font-bold">MEDINE</span>
          </div>
          <nav className="flex items-center space-x-4">
            <ul className="flex gap-6">
              <li>
                <a href="#caracteristicas" className="hover:text-accent transition-colors">
                  Características
                </a>
              </li>
              <li>
                <a href="#plataforma" className="hover:text-accent transition-colors">
                  Plataforma
                </a>
              </li>
              <li>
                <a href="#contacto" className="hover:text-accent transition-colors">
                  Soporte
                </a>
              </li>
            </ul>
            <ThemeSwitch />
          </nav>
        </div>
      </header>

      {/* Hero Section */}
      <section className="flex-grow bg-gradient-to-b from-primary/80 to-primary text-primary-foreground dark:from-slate-800 dark:to-slate-900">
        <div className="container mx-auto py-20 px-4 flex flex-col items-center">
          <h1 className="text-4xl md:text-5xl font-bold text-center mb-6">
            Backoffice Administrativo
          </h1>
          <p className="text-xl text-primary-foreground/90 dark:text-white/90 text-center max-w-3xl mb-12 font-medium">
            Gestiona los recursos de tu empresa de forma eficiente con nuestro panel administrativo
            diseñado para optimizar tus operaciones diarias.
          </p>

          <div className="grid md:grid-cols-2 gap-8 w-full max-w-4xl">
            <Card className="bg-card/10 border-border shadow-xl backdrop-blur-sm hover:shadow-primary/20 hover:border-primary/50 transition-all duration-300">
              <CardHeader>
                <CardTitle className="text-card-foreground">Iniciar Sesión</CardTitle>
                <CardDescription className="text-foreground/70 dark:text-white/70">
                  Accede a tu cuenta existente
                </CardDescription>
              </CardHeader>
              <CardContent>
                <p className="text-foreground/80 dark:text-white/80">
                  Ingresa con tus credenciales para acceder a todas las herramientas y
                  funcionalidades del panel administrativo.
                </p>
              </CardContent>
              <CardFooter>
                <Button
                  className="w-full bg-accent text-accent-foreground hover:bg-accent/80"
                  size="lg"
                  asChild
                >
                  <Link to="/login">Iniciar Sesión</Link>
                </Button>
              </CardFooter>
            </Card>

            <Card className="bg-card/10 border-border shadow-xl backdrop-blur-sm hover:shadow-primary/20 hover:border-primary/50 transition-all duration-300">
              <CardHeader>
                <CardTitle className="text-card-foreground">Crear Cuenta</CardTitle>
                <CardDescription className="text-foreground/70 dark:text-white/70">
                  Regístrate como nuevo usuario
                </CardDescription>
              </CardHeader>
              <CardContent>
                <p className="text-foreground/80 dark:text-white/80">
                  Crea una nueva cuenta para comenzar a utilizar nuestro sistema de gestión
                  empresarial avanzado.
                </p>
              </CardContent>
              <CardFooter>
                <Button
                  className="w-full bg-transparent border border-accent hover:bg-accent/20"
                  size="lg"
                  asChild
                >
                  <Link to="/register">Registrarse</Link>
                </Button>
              </CardFooter>
            </Card>
          </div>
        </div>
      </section>

      {/* Features */}
      <section id="caracteristicas" className="py-16 bg-card text-card-foreground">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-10">Características Principales</h2>

          <div className="grid md:grid-cols-3 gap-8">
            <div className="text-center p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow bg-background">
              <div className="w-16 h-16 mx-auto mb-4 rounded-full bg-accent/20 flex items-center justify-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  className="h-8 w-8 text-accent"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                  />
                </svg>
              </div>
              <h3 className="text-xl font-semibold mb-3">Análisis y Reportes</h3>
              <p className="text-foreground/80 dark:text-gray-200">
                Obtén informes detallados y visualizaciones para tomar decisiones basadas en datos.
              </p>
            </div>

            <div className="text-center p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow bg-background">
              <div className="w-16 h-16 mx-auto mb-4 rounded-full bg-accent/20 flex items-center justify-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  className="h-8 w-8 text-accent"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                  />
                </svg>
              </div>
              <h3 className="text-xl font-semibold mb-3">Seguridad Avanzada</h3>
              <p className="text-foreground/80 dark:text-gray-200">
                Protección de datos con múltiples capas de seguridad y controles de acceso
                personalizados.
              </p>
            </div>

            <div className="text-center p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow bg-background">
              <div className="w-16 h-16 mx-auto mb-4 rounded-full bg-accent/20 flex items-center justify-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  className="h-8 w-8 text-accent"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                  />
                </svg>
              </div>
              <h3 className="text-xl font-semibold mb-3">Gestión de Usuarios</h3>
              <p className="text-foreground/80 dark:text-gray-200">
                Administra permisos y roles para cada miembro de tu equipo con facilidad.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Platform Section */}
      <section id="plataforma" className="py-16 bg-muted/50 text-foreground">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-12">Nuestra Plataforma</h2>

          <div className="flex flex-col md:flex-row items-center gap-12">
            <div className="md:w-1/2">
              <h3 className="text-2xl font-semibold mb-4">Diseñada Para Tu Negocio</h3>
              <p className="text-muted-foreground mb-6">
                Nuestra plataforma integra todas las herramientas que necesitas para gestionar tu
                empresa de manera eficiente. Desde la gestión financiera hasta el seguimiento de
                inventario, todo en un solo lugar.
              </p>
              <ul className="space-y-2">
                <li className="flex items-center">
                  <svg
                    className="h-5 w-5 text-green-500 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                  Interfaz intuitiva y fácil de usar
                </li>
                <li className="flex items-center">
                  <svg
                    className="h-5 w-5 text-green-500 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                  Personalizable según tus necesidades
                </li>
                <li className="flex items-center">
                  <svg
                    className="h-5 w-5 text-green-500 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                  Actualizaciones constantes y soporte técnico
                </li>
                <li className="flex items-center">
                  <svg
                    className="h-5 w-5 text-green-500 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                  Acceso desde cualquier dispositivo
                </li>
              </ul>
            </div>
            <div className="md:w-1/2 bg-white p-6 rounded-lg shadow-xl">
              <div className="aspect-video bg-slate-200 rounded-md flex items-center justify-center">
                <span className="text-slate-600">Vista previa de la plataforma</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Contact Section */}
      <section id="contacto" className="py-16 bg-slate-900 text-white">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold mb-8">¿Necesitas Ayuda?</h2>
          <p className="max-w-2xl mx-auto text-slate-300 mb-8">
            Nuestro equipo de soporte está disponible para ayudarte con cualquier consulta o
            problema que puedas tener.
          </p>
          <Button className="bg-sky-600 hover:bg-sky-700 px-8 py-3 text-lg" size="lg">
            Contactar Soporte
          </Button>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-slate-950 text-slate-400 py-8">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <div className="mb-4 md:mb-0">
              <div className="flex items-center gap-2">
                <img src={medineLogoSrc} alt="Medine Logo" className="h-8 w-auto" />
                <span className="text-white font-semibold">MEDINE</span>
              </div>
              <p className="mt-2 text-sm">
                © {new Date().getFullYear()} Medine Tech. Todos los derechos reservados.
              </p>
            </div>
            <div className="flex gap-8">
              <div>
                <h4 className="text-white font-semibold mb-3">Empresa</h4>
                <ul className="space-y-2 text-sm">
                  <li>
                    <a href="#" className="hover:text-sky-400 transition-colors">
                      Sobre Nosotros
                    </a>
                  </li>
                  <li>
                    <a href="#" className="hover:text-sky-400 transition-colors">
                      Careers
                    </a>
                  </li>
                  <li>
                    <a href="#" className="hover:text-sky-400 transition-colors">
                      Blog
                    </a>
                  </li>
                </ul>
              </div>
              <div>
                <h4 className="text-white font-semibold mb-3">Legal</h4>
                <ul className="space-y-2 text-sm">
                  <li>
                    <a href="#" className="hover:text-sky-400 transition-colors">
                      Términos
                    </a>
                  </li>
                  <li>
                    <a href="#" className="hover:text-sky-400 transition-colors">
                      Privacidad
                    </a>
                  </li>
                  <li>
                    <a href="#" className="hover:text-sky-400 transition-colors">
                      Cookies
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}

export default LandingPage;
