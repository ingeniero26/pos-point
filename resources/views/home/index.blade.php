@extends('home.layouts.app')
@section('style')
<style>tion
@   .stats-counter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
    }
    .counter-item {
        text-align: center;
        padding: 20px;
    }
    .counter-number {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .counter-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    .feature-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        height: 100%;
    }
    .feature-card:hover {
        transform: translateY(-10px);
    }
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: white;
    }
    .hero-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>
@endsection
@section('content')
    <!-- Main Content -->
    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section hero-gradient">
            <div class="container position-relative">
                <div id="hero-carousel" class="carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
                    
                    <div class="carousel-item active">
                        <div class="carousel-container text-center">
                            <h1 class="display-4 fw-bold text-white mb-4">Sistema de Facturación Empresarial</h1>
                            <p class="lead text-white-50 mb-4">Solución completa para la gestión de ventas, compras, inventario y facturación electrónica. Desarrollado con tecnología de vanguardia para empresas modernas.</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#features" class="btn btn-light btn-lg px-4">Conocer Más</a>
                                <a href="#demo" class="btn btn-outline-light btn-lg px-4">Ver Demo</a>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="carousel-container text-center">
                            <h1 class="display-4 fw-bold text-white mb-4">Desarrollo de Software a Medida</h1>
                            <p class="lead text-white-50 mb-4">Creamos soluciones tecnológicas personalizadas para tu empresa. Especialistas en sistemas web, aplicaciones móviles y automatización de procesos.</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#services" class="btn btn-light btn-lg px-4">Nuestros Servicios</a>
                                <a href="#contact" class="btn btn-outline-light btn-lg px-4">Contactar</a>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="carousel-container text-center">
                            <h1 class="display-4 fw-bold text-white mb-4">Tecnología que Impulsa tu Negocio</h1>
                            <p class="lead text-white-50 mb-4">Laravel, PHP, JavaScript, MySQL y las mejores prácticas de desarrollo. Sistemas escalables, seguros y fáciles de usar.</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#technology" class="btn btn-light btn-lg px-4">Tecnologías</a>
                                <a href="#portfolio" class="btn btn-outline-light btn-lg px-4">Portafolio</a>
                            </div>
                        </div>
                    </div>

                    <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                    </a>

                    <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                    </a>

                    <ol class="carousel-indicators"></ol>
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- Stats Section -->
        <section class="stats-counter section">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="counter-item" data-aos="fade-up" data-aos-delay="100">
                            <div class="counter-number" data-purecounter-start="0" data-purecounter-end="1250" data-purecounter-duration="1" class="purecounter">1,250</div>
                            <div class="counter-label">Facturas Procesadas</div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="counter-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="counter-number" data-purecounter-start="0" data-purecounter-end="850" data-purecounter-duration="1" class="purecounter">850</div>
                            <div class="counter-label">Productos Gestionados</div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="counter-item" data-aos="fade-up" data-aos-delay="300">
                            <div class="counter-number" data-purecounter-start="0" data-purecounter-end="320" data-purecounter-duration="1" class="purecounter">320</div>
                            <div class="counter-label">Órdenes de Compra</div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="counter-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="counter-number" data-purecounter-start="0" data-purecounter-end="95" data-purecounter-duration="1" class="purecounter">95</div>
                            <div class="counter-label">% Satisfacción Cliente</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Services Section -->
        <section id="services" class="featured-services section light-background">
            <div class="container">
                <div class="section-title text-center mb-5" data-aos="fade-up">
                    <h2>Módulos del Sistema</h2>
                    <p>Funcionalidades completas para la gestión integral de tu empresa</p>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <h4 class="text-center mb-3">Facturación Electrónica</h4>
                            <p class="text-muted text-center">Sistema completo de facturación con generación automática de documentos, cálculo de impuestos y envío por email.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <h4 class="text-center mb-3">Gestión de Inventario</h4>
                            <p class="text-muted text-center">Control total de productos, stock, categorías, precios y movimientos de inventario en tiempo real.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-cart-plus"></i>
                            </div>
                            <h4 class="text-center mb-3">Compras y Proveedores</h4>
                            <p class="text-muted text-center">Gestión completa de órdenes de compra, recepción de mercancía y administración de proveedores.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <h4 class="text-center mb-3">Reportes y Analytics</h4>
                            <p class="text-muted text-center">Dashboards interactivos, reportes detallados y análisis de ventas para toma de decisiones estratégicas.</p>
                        </div>
                    </div>
                </div>

                <div class="row gy-4 mt-4">
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h4 class="text-center mb-3">CRM Clientes</h4>
                            <p class="text-muted text-center">Administración completa de clientes, historial de compras y seguimiento de cuentas por cobrar.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <h4 class="text-center mb-3">Contabilidad</h4>
                            <p class="text-muted text-center">Módulo contable integrado con plan de cuentas, asientos automáticos y estados financieros.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="700">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h4 class="text-center mb-3">Seguridad</h4>
                            <p class="text-muted text-center">Sistema de roles y permisos, auditoría de acciones y respaldos automáticos para proteger tu información.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="800">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </div>
                            <h4 class="text-center mb-3">Cloud & Mobile</h4>
                            <p class="text-muted text-center">Acceso desde cualquier dispositivo, sincronización en la nube y aplicación móvil para ventas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Featured Services Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{url('frontend/img/about.jpg')}}" class="img-fluid rounded shadow" alt="Desarrollo de Software">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <a href="#demo" class="btn btn-primary btn-lg rounded-circle p-4">
                                <i class="bi bi-play-fill fs-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="mb-4">Empresa Líder en Desarrollo de Software Empresarial</h3>
                        <p class="fst-italic mb-4">
                            Somos una empresa especializada en el desarrollo de soluciones tecnológicas para empresas modernas. 
                            Nuestro sistema de facturación es el resultado de años de experiencia y conocimiento del mercado.
                        </p>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><i class="bi bi-check-circle text-success me-2"></i>Experiencia Comprobada</h5>
                                <p class="text-muted">Más de 5 años desarrollando software empresarial con tecnologías de vanguardia.</p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="bi bi-check-circle text-success me-2"></i>Soporte 24/7</h5>
                                <p class="text-muted">Equipo técnico disponible para resolver cualquier inconveniente o consulta.</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><i class="bi bi-check-circle text-success me-2"></i>Actualizaciones Constantes</h5>
                                <p class="text-muted">Mejoras continuas basadas en feedback de usuarios y nuevas regulaciones.</p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="bi bi-check-circle text-success me-2"></i>Personalización</h5>
                                <p class="text-muted">Adaptamos el sistema a las necesidades específicas de tu empresa.</p>
                            </div>
                        </div>

                        <div class="bg-light p-4 rounded">
                            <h6 class="fw-bold mb-3">¿Por qué elegir nuestro sistema?</h6>
                            <ul class="list-unstyled mb-0">
                                <li><i class="bi bi-arrow-right text-primary me-2"></i>Interfaz intuitiva y fácil de usar</li>
                                <li><i class="bi bi-arrow-right text-primary me-2"></i>Cumple con todas las normativas fiscales</li>
                                <li><i class="bi bi-arrow-right text-primary me-2"></i>Integración con múltiples plataformas</li>
                                <li><i class="bi bi-arrow-right text-primary me-2"></i>Escalable según el crecimiento de tu empresa</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Technology Section -->
        <section id="technology" class="features section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Tecnologías Utilizadas</h2>
                <p>Stack tecnológico moderno y robusto para garantizar el mejor rendimiento</p>
            </div>

            <div class="container">
                <div class="row gy-4 align-items-center features-item">
                    <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
                        <div class="text-center w-100">
                            <i class="bi bi-code-slash display-1 text-primary mb-3"></i>
                            <h4>Backend Robusto</h4>
                        </div>
                    </div>
                    <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
                        <h3>Laravel & PHP - Potencia y Seguridad</h3>
                        <p class="fst-italic mb-3">
                            Desarrollado con Laravel 10, el framework PHP más popular y seguro del mercado, 
                            garantizando escalabilidad y mantenibilidad.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check text-success me-2"></i>Arquitectura MVC para código organizado y mantenible</li>
                            <li><i class="bi bi-check text-success me-2"></i>Sistema de autenticación y autorización avanzado</li>
                            <li><i class="bi bi-check text-success me-2"></i>ORM Eloquent para manejo eficiente de base de datos</li>
                            <li><i class="bi bi-check text-success me-2"></i>Middleware para seguridad y validación de requests</li>
                        </ul>
                    </div>
                </div>

                <div class="row gy-4 align-items-center features-item">
                    <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                        <div class="text-center w-100">
                            <i class="bi bi-database display-1 text-info mb-3"></i>
                            <h4>Base de Datos</h4>
                        </div>
                    </div>
                    <div class="col-md-7 order-2 order-md-1" data-aos="fade-up" data-aos-delay="200">
                        <h3>MySQL - Confiabilidad y Rendimiento</h3>
                        <p class="fst-italic mb-3">
                            Base de datos MySQL optimizada con índices estratégicos, relaciones bien definidas 
                            y respaldos automáticos para garantizar la integridad de la información.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-arrow-right text-primary me-2"></i>Transacciones ACID</li>
                                    <li><i class="bi bi-arrow-right text-primary me-2"></i>Índices optimizados</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-arrow-right text-primary me-2"></i>Respaldos automáticos</li>
                                    <li><i class="bi bi-arrow-right text-primary me-2"></i>Replicación de datos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gy-4 align-items-center features-item">
                    <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out">
                        <div class="text-center w-100">
                            <i class="bi bi-browser-chrome display-1 text-warning mb-3"></i>
                            <h4>Frontend Moderno</h4>
                        </div>
                    </div>
                    <div class="col-md-7" data-aos="fade-up">
                        <h3>JavaScript & Bootstrap - Experiencia de Usuario Superior</h3>
                        <p class="mb-3">
                            Interfaz moderna y responsiva desarrollada con las últimas tecnologías frontend 
                            para una experiencia de usuario excepcional en cualquier dispositivo.
                        </p>
                        <div class="bg-light p-3 rounded">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <i class="bi bi-bootstrap text-primary fs-2"></i>
                                    <p class="small mt-2 mb-0">Bootstrap 5</p>
                                </div>
                                <div class="col-md-3">
                                    <i class="bi bi-filetype-js text-warning fs-2"></i>
                                    <p class="small mt-2 mb-0">JavaScript ES6+</p>
                                </div>
                                <div class="col-md-3">
                                    <i class="bi bi-table text-success fs-2"></i>
                                    <p class="small mt-2 mb-0">DataTables</p>
                                </div>
                                <div class="col-md-3">
                                    <i class="bi bi-graph-up text-info fs-2"></i>
                                    <p class="small mt-2 mb-0">Chart.js</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gy-4 align-items-center features-item">
                    <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out">
                        <div class="text-center w-100">
                            <i class="bi bi-cloud-check display-1 text-success mb-3"></i>
                            <h4>Infraestructura</h4>
                        </div>
                    </div>
                    <div class="col-md-7 order-2 order-md-1" data-aos="fade-up">
                        <h3>Despliegue y Hosting Profesional</h3>
                        <p class="fst-italic mb-3">
                            Infraestructura en la nube con alta disponibilidad, SSL, CDN y monitoreo 24/7 
                            para garantizar que tu sistema esté siempre disponible.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="bi bi-shield-check text-success me-2"></i>Seguridad SSL</h6>
                                <h6><i class="bi bi-speedometer2 text-primary me-2"></i>CDN Global</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-arrow-clockwise text-info me-2"></i>Respaldos Diarios</h6>
                                <h6><i class="bi bi-activity text-warning me-2"></i>Monitoreo 24/7</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Technology Section -->

        <!-- Demo Section -->
        <section id="demo" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                        <h2 class="mb-4">Prueba Nuestro Sistema</h2>
                        <p class="lead mb-5">
                            Experimenta todas las funcionalidades de nuestro sistema de facturación. 
                            Accede a la demo con datos de prueba y descubre por qué somos la mejor opción para tu empresa.
                        </p>
                        
                        <div class="row gy-4 mb-5">
                            <div class="col-md-4">
                                <div class="bg-light p-4 rounded h-100">
                                    <i class="bi bi-person-circle display-4 text-primary mb-3"></i>
                                    <h5>Demo Administrador</h5>
                                    <p class="text-muted mb-3">Acceso completo a todas las funcionalidades del sistema</p>
                                    <a href="{{ url('admin/dashboard') }}" class="btn btn-primary">Acceder como Admin</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-4 rounded h-100">
                                    <i class="bi bi-shop display-4 text-success mb-3"></i>
                                    <h5>Demo Vendedor</h5>
                                    <p class="text-muted mb-3">Interfaz optimizada para el proceso de ventas</p>
                                    <a href="{{ url('user/dashboard') }}" class="btn btn-success">Acceder como Vendedor</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-4 rounded h-100">
                                    <i class="bi bi-file-earmark-text display-4 text-info mb-3"></i>
                                    <h5>Documentación</h5>
                                    <p class="text-muted mb-3">Guías completas y manuales de usuario</p>
                                    <a href="#" class="btn btn-info">Ver Documentación</a>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Datos de Prueba:</strong> El sistema incluye datos de ejemplo para que puedas probar todas las funcionalidades sin restricciones.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="section light-background">
            <div class="container">
                <div class="section-title text-center mb-5" data-aos="fade-up">
                    <h2>Contacta con Nosotros</h2>
                    <p>¿Listo para transformar tu empresa? Contáctanos para una demostración personalizada</p>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-envelope display-4 text-primary mb-3"></i>
                            <h3>Email</h3>
                            <p>contacto@tuempresa.com</p>
                            <p>soporte@tuempresa.com</p>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-telephone display-4 text-success mb-3"></i>
                            <h3>Teléfono</h3>
                            <p>+57 (1) 234-5678</p>
                            <p>+57 300 123 4567</p>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-8 mx-auto">
                        <div class="card shadow">
                            <div class="card-body p-5">
                                <h4 class="card-title text-center mb-4">Solicita una Demostración</h4>
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nombre Completo</label>
                                            <input type="text" class="form-control" id="name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="company" class="form-label">Empresa</label>
                                            <input type="text" class="form-control" id="company" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Teléfono</label>
                                            <input type="tel" class="form-control" id="phone" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Mensaje</label>
                                        <textarea class="form-control" id="message" rows="4" placeholder="Cuéntanos sobre tu empresa y necesidades..."></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">Enviar Solicitud</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <!-- /Main Content -->
@endsection

@section('script')
<script>
    // Counter animation
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter-number');
        
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-purecounter-end'));
            const duration = parseInt(counter.getAttribute('data-purecounter-duration')) * 1000;
            const start = parseInt(counter.getAttribute('data-purecounter-start'));
            
            let current = start;
            const increment = target / (duration / 16);
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.textContent = Math.floor(current).toLocaleString();
            }, 16);
        };

        // Intersection Observer for counter animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });

        counters.forEach(counter => {
            observer.observe(counter);
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Contact form submission
    document.querySelector('#contact form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simulate form submission
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.textContent;
        
        button.textContent = 'Enviando...';
        button.disabled = true;
        
        setTimeout(() => {
            alert('¡Gracias por tu interés! Nos pondremos en contacto contigo pronto.');
            this.reset();
            button.textContent = originalText;
            button.disabled = false;
        }, 2000);
    });
</script>
@endsection