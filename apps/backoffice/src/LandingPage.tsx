          <div className="flex justify-center">
            <div className="bg-blue-900/50 p-8 rounded-xl shadow-xl max-w-md w-full">
              <div className="space-y-4 text-center">
                <p className="text-blue-100">¿Tienes preguntas sobre nuestras soluciones? Estamos aquí para ayudarte.</p>
                <Button className="bg-white text-blue-900 hover:bg-blue-100 w-full" size="lg">
                  Enviar Mensaje
                </Button>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-blue-950 text-white py-8 border-t border-blue-800">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <div className="text-sm text-blue-300 mb-4 md:mb-0">
              © {new Date().getFullYear()} Medine. Todos los derechos reservados.
            </div>
            <div className="flex gap-6">
              <Link to="/terminos" className="text-sm text-blue-300 hover:text-white transition-colors">
                Términos de Servicio
              </Link>
              <Link to="/privacidad" className="text-sm text-blue-300 hover:text-white transition-colors">
                Política de Privacidad
              </Link>
              <Link to="/contacto" className="text-sm text-blue-300 hover:text-white transition-colors">
                Contáctanos
              </Link>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}
