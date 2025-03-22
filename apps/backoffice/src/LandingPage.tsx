import { Link } from "react-router-dom";
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import medineLogoSrc from "./assets/medine-logo.svg";

export function LandingPage() {
  return (
    <div className="min-h-screen flex flex-col">
      {/* Header */}
      <header className="bg-slate-900 text-white py-4 px-6 shadow-md">
        <div className="container mx-auto flex justify-between items-center">
          <div className="flex items-center gap-2">
            <img 
              src={medineLogoSrc} 
              alt="Medine Logo" 
              className="h-10 w-auto"
            />
            <span className="text-xl font-bold">MEDINE</span>
          </div>
          <nav>
            <ul className="flex gap-6">
              <li>
                <a href="#caracteristicas" className="hover:text-sky-400 transition-colors">
                  Características
                </a>
              </li>
              <li>
                <a href="#plataforma" className="hover:text-sky-400 transition-colors">
                  Plataforma
                </a>
              </li>
              <li>
                <a href="#contacto" className="hover:text-sky-400 transition-colors">
                  Soporte
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </header>

      {/* Hero Section */}
      <section className="flex-grow bg-gradient-to-b from-slate-800 to-slate-900 text-white">
        <div className="container mx-auto py-20 px-4 flex flex-col items-center">
          <h1 className="text-4xl md:text-5xl font-bold text-center mb-6">Backoffice Administrativo</h1>
          <p className="text-xl text-slate-300 text-center max-w-3xl mb-12">
            Gestiona los recursos de tu empresa de forma eficiente con nuestro panel administrativo diseñado para optimizar tus operaciones diarias.
          </p>
          
          <div className="grid md:grid-cols-2 gap-8 w-full max-w-4xl">
            <Card className="bg-white/10 border-slate-700 shadow-xl backdrop-blur-sm hover:shadow-sky-900/20 hover:border-sky-800/50 transition-all duration-300">
              <CardHeader>
                <CardTitle className="text-white">Iniciar Sesión</CardTitle>
                <CardDescription className="text-slate-300">
                  Accede a tu cuenta existente
                </CardDescription>
              </CardHeader>
              <CardContent>
                <p className="text-slate-300">
                  Ingresa con tus credenciales para acceder a todas las herramientas
                  y funcionalidades del panel administrativo.
                </p>
              </CardContent>
              <CardFooter>
                <Button className="w-full bg-sky-600 text-white hover:bg-sky-700" size="lg" asChild>
                  <Link to="/login">
                    Iniciar Sesión
                  </Link>
                </Button>
              </CardFooter>
            </Card>

            <Card className="bg-white/10 border-slate-700 shadow-xl backdrop-blur-sm hover:shadow-sky-900/20 hover:border-sky-800/50 transition-all duration-300">
              <CardHeader>
                <CardTitle className="text-white">Crear Cuenta</CardTitle>
                <CardDescription className="text-slate-300">
                  Regístrate como nuevo usuario
                </CardDescription>
              </CardHeader>
              <CardContent>
                <p className="text-slate-300">
                  Crea una nueva cuenta para comenzar a utilizar nuestro
                  sistema de gestión empresarial avanzado.
                </p>
              </CardContent>
              <CardFooter>
                <Button className="w-full bg-transparent border border-sky-600 hover:bg-sky-900/20" size="lg" asChild>
                  <Link to="/register">
                    Registrarse
                  </Link>
                </Button>
              </CardFooter>
            </Card>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section id="caracteristicas" className="bg-slate-900 text-white py-16">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-12">Características Principales</h2>
          <div className="grid md:grid-cols-3 gap-8">
            <div className="bg-slate-800 p-6 rounded-lg shadow-lg border border-slate-700 hover:border-sky-800/50 transition-all duration-300">
              <div className="text-sky-500 text-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="w-8 h-8 mb-2"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
              </div>
              <h3 className="text-xl font-semibold mb-2">Gestión Integral</h3>
              <p className="text-slate-300">
                Administra todos los aspectos de tu negocio desde una única plataforma intuitiva y potente.
              </p>
            </div>
            
            <div className="bg-slate-800 p-6 rounded-lg shadow-lg border border-slate-700 hover:border-sky-800/50 transition-all duration-300">
              <div className="text-sky-500 text-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="w-8 h-8 mb-2"><path d="M3 3v18h18"></path><path d="m19 9-5 5-4-4-3 3"></path></svg>
              </div>
              <h3 className="text-xl font-semibold mb-2">Análisis Avanzado</h3>
              <p className="text-slate-300">
                Obtén información valiosa con nuestro sistema de reportes y análisis de datos en tiempo real.
              </p>
            </div>
            
            <div className="bg-slate-800 p-6 rounded-lg shadow-lg border border-slate-700 hover:border-sky-800/50 transition-all duration-300">
              <div className="text-sky-500 text-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="w-8 h-8 mb-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path><path d="M15.83 15.87c-.52.51-1.2.77-1.88.77m0 0c-.67 0-1.35-.26-1.87-.77m3.75 0L15 12m-2.05 4.64-1.79-3.96C12.09 12.05 13.59 10.32 13 8"></path></svg>
              </div>
              <h3 className="text-xl font-semibold mb-2">Seguridad Avanzada</h3>
              <p className="text-slate-300">
                Protege tu información empresarial con sistemas de seguridad de última generación y autenticación multinivel.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Platform Section */}
      <section id="plataforma" className="bg-slate-800 text-white py-16">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-8">Nuestra Plataforma</h2>
          <p className="text-xl text-center max-w-3xl mx-auto mb-12 text-slate-300">
            Una suite completa de herramientas diseñadas para optimizar la gestión de tu negocio
          </p>
          <div className="grid md:grid-cols-2 gap-12 items-center">
            <div className="bg-slate-900/50 p-8 rounded-xl shadow-xl border border-slate-700">
              <h3 className="text-2xl font-semibold mb-4 text-sky-400">Intuitivo y Potente</h3>
              <ul className="space-y-3">
                <li className="flex items-start gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-sky-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span className="text-slate-300">Interfaz fácil de usar diseñada para maximizar la productividad</span>
                </li>
                <li className="flex items-start gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-sky-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span className="text-slate-300">Dashboards personalizables para visualizar KPIs importantes</span>
                </li>
                <li className="flex items-start gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-sky-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span className="text-slate-300">Gestión completa de recursos humanos y financieros</span>
                </li>
              </ul>
            </div>
            <div className="bg-slate-900/50 p-8 rounded-xl shadow-xl border border-slate-700">
              <h3 className="text-2xl font-semibold mb-4 text-sky-400">Totalmente Integrado</h3>
              <ul className="space-y-3">
                <li className="flex items-start gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-sky-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span className="text-slate-300">Integración perfecta con sistemas de terceros y APIs</span>
                </li>
                <li className="flex items-start gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-sky-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span className="text-slate-300">Flujos de trabajo automatizados que incrementan la eficiencia</span>
                </li>
                <li className="flex items-start gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-sky-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span className="text-slate-300">Plataforma escalable que crece con tu negocio</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* Contact Section */}
      <section id="contacto" className="bg-slate-900 text-white py-16">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-8">Soporte Técnico</h2>
          <div className="flex justify-center">
            <div className="bg-slate-800 p-8 rounded-xl shadow-xl max-w-md w-full border border-slate-700">
              <div className="space-y-6 text-center">
                <p className="text-slate-300">¿Necesitas ayuda con la plataforma? Nuestro equipo de soporte está disponible para asistirte.</p>
                <div className="flex flex-col space-y-4">
                  <Button className="bg-sky-600 text-white hover:bg-sky-700 w-full" size="lg">
                    Contactar Soporte
                  </Button>
                  <Button className="bg-transparent border border-slate-600 text-white hover:bg-slate-800 w-full" size="lg">
                    Ver Documentación
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-slate-900 text-white py-8 border-t border-slate-800">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <div className="text-sm text-slate-400 mb-4 md:mb-0">
              © {new Date().getFullYear()} Medine. Todos los derechos reservados.
            </div>
            <div className="flex gap-6">
              <Link to="/terminos" className="text-sm text-slate-400 hover:text-white transition-colors">
                Términos de Servicio
              </Link>
              <Link to="/privacidad" className="text-sm text-slate-400 hover:text-white transition-colors">
                Política de Privacidad
              </Link>
              <Link to="/ayuda" className="text-sm text-slate-400 hover:text-white transition-colors">
                Centro de Ayuda
              </Link>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}
