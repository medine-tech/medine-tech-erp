import {
  ArrowLeftRight,
  BarChart3,
  Building2,
  Calculator,
  ChevronRight,
  ClipboardList,
  Globe2,
  LineChart,
  Package,
  Settings,
  Shield,
  Users,
} from "lucide-react";
import Link from "next/link";
import type React from "react";

import MedineLogo from "@/app/components/medine-logo";
import { Button } from "@/app/components/ui/button";
import { Card } from "@/app/components/ui/card";

export default function LandingPage() {
  const currentYear = new Date().getFullYear();

  return (
    <div className="flex min-h-screen flex-col">
      {/* Header Navigation */}
      <header className="fixed top-0 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 z-50">
        <div className="container flex h-16 items-center justify-between">
          <div className="flex items-center gap-2">
            <MedineLogo width={40} height={40} />
            <span className="text-xl font-bold">MedineTech</span>
          </div>
          <nav className="flex items-center gap-4">
            <Button variant="ghost" asChild>
              <Link href="/login">Iniciar Sesión</Link>
            </Button>
            <Button asChild>
              <Link href="/register">Registrar Empresa</Link>
            </Button>
          </nav>
        </div>
      </header>

      {/* Hero Section */}
      <section className="pt-24 lg:pt-32">
        <div className="container flex flex-col items-center gap-8 text-center">
          <div className="space-y-4">
            <h1 className="text-4xl font-bold tracking-tighter sm:text-5xl md:text-6xl">
              Gestiona Múltiples Empresas <br className="hidden sm:inline" />
              desde una Única Plataforma
            </h1>
            <p className="mx-auto max-w-[700px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
              Sistema ERP integral que te permite administrar todas tus empresas de manera
              centralizada
            </p>
          </div>
          <div className="flex flex-wrap items-center justify-center gap-4">
            <Button size="lg" asChild>
              <Link href="/register">
                Comenzar Ahora
                <ChevronRight className="ml-2 h-4 w-4" />
              </Link>
            </Button>
            <Button variant="outline" size="lg" asChild>
              <Link href="/login">Acceder al Sistema</Link>
            </Button>
          </div>

          {/* Multi-company Preview */}
          <div className="w-full max-w-5xl mx-auto mt-8">
            <div className="relative rounded-xl border bg-background p-4 overflow-hidden">
              <div className="absolute inset-0 bg-gradient-to-br from-primary/10 to-secondary/10" />
              <div className="relative grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                {["Empresa A", "Empresa B", "Empresa C"].map((company) => (
                  <Card key={company} className="p-4 backdrop-blur-sm bg-white/50">
                    <div className="flex items-center gap-3">
                      <div className="rounded-full bg-primary/10 p-2">
                        <Building2 className="h-5 w-5 text-primary" />
                      </div>
                      <div>
                        <h3 className="font-semibold">{company}</h3>
                        <p className="text-sm text-muted-foreground">Gestión Activa</p>
                      </div>
                    </div>
                  </Card>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Multi-company Management Section */}
      <section className="py-20 bg-slate-50">
        <div className="container">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold tracking-tighter mb-4">
              Todo lo que Necesitas para Gestionar Múltiples Empresas
            </h2>
            <p className="text-muted-foreground md:text-lg max-w-[800px] mx-auto">
              Centraliza la gestión de todas tus empresas en una única plataforma potente y fácil de
              usar
            </p>
          </div>
          <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <FeatureCard
              icon={Building2}
              title="Gestión Multi-empresa"
              description="Administra múltiples empresas desde una sola cuenta con acceso centralizado"
            />
            <FeatureCard
              icon={ArrowLeftRight}
              title="Cambio Rápido"
              description="Cambia entre empresas instantáneamente sin necesidad de cerrar sesión"
            />
            <FeatureCard
              icon={Shield}
              title="Control de Acceso"
              description="Define permisos específicos para cada empresa y usuario"
            />
            <FeatureCard
              icon={Settings}
              title="Configuración Individual"
              description="Personaliza la configuración de cada empresa según sus necesidades"
            />
            <FeatureCard
              icon={LineChart}
              title="Reportes Consolidados"
              description="Obtén informes individuales o consolidados de todas tus empresas"
            />
            <FeatureCard
              icon={Globe2}
              title="Acceso Global"
              description="Accede a tus empresas desde cualquier lugar y dispositivo"
            />
          </div>
        </div>
      </section>

      {/* Core Modules Section */}
      <section className="py-20">
        <div className="container">
          <h2 className="text-3xl font-bold tracking-tighter text-center mb-12">
            Módulos Principales
          </h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <ModuleCard
              icon={Package}
              title="Inventario"
              description="Gestión eficiente de productos, stock y almacenes para cada empresa"
            />
            <ModuleCard
              icon={BarChart3}
              title="Ventas"
              description="Control completo del ciclo de ventas y facturación por empresa"
            />
            <ModuleCard
              icon={Calculator}
              title="Compras"
              description="Optimización de procesos de adquisición y proveedores"
            />
            <ModuleCard
              icon={Users}
              title="Recursos Humanos"
              description="Administración integral del personal de cada empresa"
            />
            <ModuleCard
              icon={ClipboardList}
              title="Nómina"
              description="Gestión automatizada de pagos y prestaciones por empresa"
            />
            <ModuleCard
              icon={BarChart3}
              title="Reportes"
              description="Análisis detallado individual y consolidado de tus empresas"
            />
          </div>
        </div>
      </section>

      {/* Testimonials Section */}
      <section className="py-20 bg-slate-50">
        <div className="container">
          <h2 className="text-3xl font-bold tracking-tighter text-center mb-12">
            Lo que Dicen Nuestros Clientes
          </h2>
          <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <TestimonialCard
              quote="Gestionar mis tres empresas nunca había sido tan fácil. Todo centralizado en un solo lugar."
              author="María González"
              role="Directora General"
              company="Grupo Empresarial MTZ"
            />
            <TestimonialCard
              quote="La capacidad de cambiar entre empresas y mantener todo organizado nos ha ahorrado horas de trabajo."
              author="Carlos Ruiz"
              role="Gerente de Operaciones"
              company="Corporativo CR"
            />
            <TestimonialCard
              quote="Los reportes consolidados nos dan una visión clara del rendimiento de todas nuestras empresas."
              author="Ana Martínez"
              role="Directora Financiera"
              company="Holding AM"
            />
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20">
        <div className="container">
          <div className="flex flex-col items-center gap-4 text-center">
            <h2 className="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">
              Comienza a Gestionar tus Empresas
            </h2>
            <p className="mx-auto max-w-[600px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
              Una cuenta. Múltiples empresas. Control total.
            </p>
            <div className="flex flex-wrap items-center justify-center gap-4">
              <Button size="lg" asChild>
                <Link href="/register">Registrar mi Primera Empresa</Link>
              </Button>
              <Button variant="outline" size="lg" asChild>
                <Link href="/login">Ya tengo una cuenta</Link>
              </Button>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="border-t bg-slate-50">
        <div className="container flex flex-col gap-4 py-10 md:flex-row md:justify-between">
          <div className="flex items-center gap-2">
            <MedineLogo width={30} height={30} />
            <span className="text-lg font-semibold">MedineTech</span>
          </div>
          <p className="text-sm text-muted-foreground">
            © {currentYear} MedineTech. Todos los derechos reservados.
          </p>
        </div>
      </footer>
    </div>
  );
}

function FeatureCard({
  icon: Icon,
  title,
  description,
}: {
  icon: React.ElementType;
  title: string;
  description: string;
}) {
  return (
    <div className="flex flex-col items-center text-center p-6 space-y-4 rounded-lg border bg-card transition-colors hover:bg-accent">
      <div className="rounded-full bg-primary/10 p-3">
        <Icon className="h-6 w-6 text-primary" />
      </div>
      <h3 className="text-xl font-semibold">{title}</h3>
      <p className="text-muted-foreground">{description}</p>
    </div>
  );
}

function ModuleCard({
  icon: Icon,
  title,
  description,
}: {
  icon: React.ElementType;
  title: string;
  description: string;
}) {
  return (
    <div className="flex flex-col p-6 space-y-4 rounded-lg border bg-card transition-colors hover:bg-accent">
      <div className="rounded-full bg-primary/10 p-3 w-fit">
        <Icon className="h-6 w-6 text-primary" />
      </div>
      <h3 className="text-xl font-semibold">{title}</h3>
      <p className="text-muted-foreground">{description}</p>
    </div>
  );
}

function TestimonialCard({
  quote,
  author,
  role,
  company,
}: {
  quote: string;
  author: string;
  role: string;
  company: string;
}) {
  return (
    <div className="flex flex-col p-6 space-y-4 rounded-lg border bg-card">
      <p className="text-muted-foreground italic">"{quote}"</p>
      <div>
        <p className="font-semibold">{author}</p>
        <p className="text-sm text-muted-foreground">{role}</p>
        <p className="text-sm text-primary">{company}</p>
      </div>
    </div>
  );
}
