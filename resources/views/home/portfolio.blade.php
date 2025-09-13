@extends('home.layouts.app')
@section('style')
<style>
    .portfolio-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0;
    }
    .portfolio-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }
    .portfolio-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .portfolio-image {
        height: 250px;
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }
    .portfolio-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .portfolio-card:hover .portfolio-overlay {
        opacity: 1;
    }
    .tech-badge {
        background: #f8f9fa;
        color: #495057;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        margin: 2px;
        display: inline-block;
    }
    .project-stats {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin: 15px 0;
    }
    .stat-item {
        text-align: center;
        padding: 10px;
    }
    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #667eea;
    }
    .filter-btn {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        padding: 8px 20px;
        border-radius: 25px;
        margin: 5px;
        transition: all 0.3s ease;
    }
    .filter-btn.active,
    .filter-btn:hover {
        background: #667eea;
        color: white;
    }
</style>
@endsection
@section('content')
<main class="main">

    <!-- Portfolio Hero -->
    <section class="portfolio-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Nuestro Portafolio</h1>
                    <p class="lead mb-4">
                        Proyectos exitosos que demuestran nuestra experiencia en desarrollo de software empresarial, 
                        sistemas de facturación y soluciones tecnológicas innovadoras.
                    </p>
                    <div class="d-flex gap-3">
                        <div class="text-center">
                            <div class="h3 fw-bold">50+</div>
                            <small>Proyectos Completados</small>
                        </div>
                        <div class="text-center">
                            <div class="h3 fw-bold">98%</div>
                            <small>Satisfacción Cliente</small>
                        </div>
                        <div class="text-center">
                            <div class="h3 fw-bold">5+</div>
                            <small>Años Experiencia</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-laptop display-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">
        <div class="container">
            <!-- Section Title -->
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>Proyectos Destacados</h2>
                <p class="lead">Soluciones tecnológicas que han transformado empresas</p>
            </div>

            <!-- Portfolio Filters -->
            <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="*">Todos los Proyectos</button>
                <button class="filter-btn" data-filter=".filter-billing">Sistemas de Facturación</button>
                <button class="filter-btn" data-filter=".filter-erp">ERP Empresarial</button>
                <button class="filter-btn" data-filter=".filter-ecommerce">E-commerce</button>
                <button class="filter-btn" data-filter=".filter-mobile">Apps Móviles</button>
                <button class="filter-btn" data-filter=".filter-web">Aplicaciones Web</button>
            </div>

            <!-- Portfolio Grid -->
            <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">

                <!-- Sistema de Facturación Principal -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-billing">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45deg, #667eea, #764ba2);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-receipt display-4 mb-3"></i>
                                    <h5>Ver Detalles</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">Sistema de Facturación Empresarial</h4>
                            <p class="text-muted mb-3">Plataforma completa de facturación electrónica con gestión de inventario, CRM y contabilidad integrada.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">1,250+</div>
                                        <small>Facturas</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">850+</div>
                                        <small>Productos</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">15+</div>
                                        <small>Empresas</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">Laravel</span>
                                <span class="tech-badge">PHP</span>
                                <span class="tech-badge">MySQL</span>
                                <span class="tech-badge">JavaScript</span>
                                <span class="tech-badge">Bootstrap</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2024 - En Desarrollo</small>
                                <a href="{{ url('admin/dashboard') }}" class="btn btn-primary btn-sm">Ver Demo</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ERP Empresarial -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-erp">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45deg, #11998e, #38ef7d);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-building display-4 mb-3"></i>
                                    <h5>Ver Proyecto</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">ERP Gestión Empresarial</h4>
                            <p class="text-muted mb-3">Sistema integral de planificación de recursos empresariales con módulos de RRHH, finanzas y operaciones.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">500+</div>
                                        <small>Usuarios</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">25</div>
                                        <small>Módulos</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">99.9%</div>
                                        <small>Uptime</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">Laravel</span>
                                <span class="tech-badge">Vue.js</span>
                                <span class="tech-badge">PostgreSQL</span>
                                <span class="tech-badge">Redis</span>
                                <span class="tech-badge">Docker</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2023 - Completado</small>
                                <button class="btn btn-success btn-sm">Caso de Éxito</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- E-commerce Platform -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-ecommerce">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45deg, #ff6b6b, #feca57);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-cart display-4 mb-3"></i>
                                    <h5>Ver Tienda</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">Plataforma E-commerce</h4>
                            <p class="text-muted mb-3">Tienda online completa con pasarela de pagos, gestión de inventario y panel administrativo avanzado.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">2,500+</div>
                                        <small>Productos</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">10K+</div>
                                        <small>Ventas</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">95%</div>
                                        <small>Conversión</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">Laravel</span>
                                <span class="tech-badge">Stripe</span>
                                <span class="tech-badge">AWS</span>
                                <span class="tech-badge">React</span>
                                <span class="tech-badge">MySQL</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2023 - Activo</small>
                                <button class="btn btn-warning btn-sm">Ver Online</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- App Móvil de Ventas -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-mobile">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45deg, #a8edea, #fed6e3);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-phone display-4 mb-3"></i>
                                    <h5>Ver App</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">App Móvil de Ventas</h4>
                            <p class="text-muted mb-3">Aplicación móvil para vendedores con sincronización offline, catálogo de productos y generación de pedidos.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">150+</div>
                                        <small>Vendedores</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">5K+</div>
                                        <small>Pedidos</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">4.8★</div>
                                        <small>Rating</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">React Native</span>
                                <span class="tech-badge">Firebase</span>
                                <span class="tech-badge">SQLite</span>
                                <span class="tech-badge">Push Notifications</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2024 - Lanzado</small>
                                <button class="btn btn-info btn-sm">Descargar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sistema de Inventario -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45deg, #667eea, #764ba2);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-boxes display-4 mb-3"></i>
                                    <h5>Ver Sistema</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">Sistema de Inventario Inteligente</h4>
                            <p class="text-muted mb-3">Gestión avanzada de inventario con códigos de barras, alertas automáticas y reportes en tiempo real.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">50K+</div>
                                        <small>Productos</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">20</div>
                                        <small>Bodegas</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">99%</div>
                                        <small>Precisión</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">Laravel</span>
                                <span class="tech-badge">Vue.js</span>
                                <span class="tech-badge">Barcode Scanner</span>
                                <span class="tech-badge">Chart.js</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2023 - Operativo</small>
                                <button class="btn btn-primary btn-sm">Ver Demo</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sistema POS -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-billing">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45th, #ff9a9e, #fecfef);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-cash-register display-4 mb-3"></i>
                                    <h5>Ver POS</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">Sistema POS Táctil</h4>
                            <p class="text-muted mb-3">Punto de venta táctil con impresión de tickets, manejo de efectivo y tarjetas, ideal para retail.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">25</div>
                                        <small>Tiendas</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">100K+</div>
                                        <small>Transacciones</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">2s</div>
                                        <small>Velocidad</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">Laravel</span>
                                <span class="tech-badge">JavaScript</span>
                                <span class="tech-badge">Thermal Printer</span>
                                <span class="tech-badge">Payment Gateway</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2024 - Activo</small>
                                <a href="{{ url('admin/pos') }}" class="btn btn-success btn-sm">Probar POS</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API REST para Integración -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45deg, #4facfe, #00f2fe);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-cloud display-4 mb-3"></i>
                                    <h5>Ver API</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">API REST de Integración</h4>
                            <p class="text-muted mb-3">API robusta para integración con sistemas externos, webhooks y sincronización de datos en tiempo real.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">50+</div>
                                        <small>Endpoints</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">1M+</div>
                                        <small>Requests/día</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">99.9%</div>
                                        <small>Uptime</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">Laravel API</span>
                                <span class="tech-badge">JWT Auth</span>
                                <span class="tech-badge">Swagger</span>
                                <span class="tech-badge">Rate Limiting</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2024 - Producción</small>
                                <button class="btn btn-info btn-sm">Ver Docs</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Analytics -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45deg, #fa709a, #fee140);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-graph-up display-4 mb-3"></i>
                                    <h5>Ver Dashboard</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">Dashboard de Analytics</h4>
                            <p class="text-muted mb-3">Panel de control con métricas en tiempo real, reportes interactivos y análisis predictivo de ventas.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">25+</div>
                                        <small>Métricas</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">15</div>
                                        <small>Reportes</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">Real-time</div>
                                        <small>Updates</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">Chart.js</span>
                                <span class="tech-badge">WebSockets</span>
                                <span class="tech-badge">Laravel Echo</span>
                                <span class="tech-badge">Redis</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2024 - Activo</small>
                                <a href="{{ url('admin/dashboard') }}" class="btn btn-primary btn-sm">Ver Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sistema de Reportes -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-billing">
                    <div class="portfolio-card">
                        <div class="portfolio-image" style="background-image: linear-gradient(45deg, #a8edea, #fed6e3);">
                            <div class="portfolio-overlay">
                                <div class="text-center text-white">
                                    <i class="bi bi-file-earmark-bar-graph display-4 mb-3"></i>
                                    <h5>Ver Reportes</h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-2">Sistema de Reportes Avanzados</h4>
                            <p class="text-muted mb-3">Generación automática de reportes financieros, exportación a múltiples formatos y programación de envíos.</p>
                            
                            <div class="project-stats">
                                <div class="row">
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">50+</div>
                                        <small>Tipos</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">5</div>
                                        <small>Formatos</small>
                                    </div>
                                    <div class="col-4 stat-item">
                                        <div class="stat-number">Auto</div>
                                        <small>Programado</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="tech-badge">Laravel Excel</span>
                                <span class="tech-badge">DomPDF</span>
                                <span class="tech-badge">Queue Jobs</span>
                                <span class="tech-badge">Email</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">2024 - Operativo</small>
                                <button class="btn btn-success btn-sm">Ver Reportes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section light-background">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>Lo que Dicen Nuestros Clientes</h2>
                <p class="lead">Testimonios reales de empresas que han transformado sus procesos con nuestras soluciones</p>
            </div>

            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle p-2 me-3">
                                    <i class="bi bi-person-fill text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">María González</h6>
                                    <small class="text-muted">Gerente General - Distribuidora XYZ</small>
                                </div>
                            </div>
                            <p class="text-muted mb-3">"El sistema de facturación ha revolucionado nuestra operación. Ahora procesamos el doble de facturas en la mitad del tiempo."</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle p-2 me-3">
                                    <i class="bi bi-person-fill text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Carlos Rodríguez</h6>
                                    <small class="text-muted">Director IT - Empresa ABC</small>
                                </div>
                            </div>
                            <p class="text-muted mb-3">"La integración con nuestros sistemas existentes fue perfecta. El equipo técnico es excepcional y el soporte es inmediato."</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info rounded-circle p-2 me-3">
                                    <i class="bi bi-person-fill text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Ana Martínez</h6>
                                    <small class="text-muted">Contadora - Comercial 123</small>
                                </div>
                            </div>
                            <p class="text-muted mb-3">"Los reportes automáticos nos ahorran horas de trabajo cada mes. La precisión de los datos es impecable."</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h2 class="text-white mb-3">¿Listo para Transformar tu Empresa?</h2>
                    <p class="text-white-50 mb-4 lead">
                        Únete a más de 50 empresas que ya han optimizado sus procesos con nuestras soluciones. 
                        Solicita una demostración personalizada y descubre cómo podemos ayudarte.
                    </p>
                </div>
                <div class="col-lg-4 text-center" data-aos="fade-left">
                    <a href="{{ url('home/contact') }}" class="btn btn-light btn-lg px-5 py-3">
                        <i class="bi bi-calendar-check me-2"></i>Solicitar Demo
                    </a>
                    <p class="text-white-50 mt-2 mb-0">
                        <small><i class="bi bi-shield-check me-1"></i>Sin compromiso • Gratis • 30 minutos</small>
                    </p>
                </div>
            </div>
        </div>
    </section>

    </main>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Portfolio filtering
        const filterButtons = document.querySelectorAll('.filter-btn');
        const portfolioItems = document.querySelectorAll('.portfolio-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                portfolioItems.forEach(item => {
                    if (filterValue === '*' || item.classList.contains(filterValue.substring(1))) {
                        item.style.display = 'block';
                        item.style.animation = 'fadeIn 0.5s ease-in-out';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);

        // Portfolio card hover effects
        const portfolioCards = document.querySelectorAll('.portfolio-card');
        
        portfolioCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Smooth scroll for internal links
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

        // Counter animation for stats
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const finalValue = stat.textContent;
                        if (!isNaN(parseInt(finalValue))) {
                            animateNumber(stat, 0, parseInt(finalValue), 1000);
                        }
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all project stats
        document.querySelectorAll('.project-stats').forEach(stats => {
            observer.observe(stats);
        });

        function animateNumber(element, start, end, duration) {
            const range = end - start;
            const increment = range / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= end) {
                    current = end;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current).toLocaleString();
            }, 16);
        }

        // Add loading animation
        const portfolioContainer = document.querySelector('.portfolio-container');
        if (portfolioContainer) {
            portfolioContainer.style.opacity = '0';
            portfolioContainer.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                portfolioContainer.style.transition = 'all 0.6s ease';
                portfolioContainer.style.opacity = '1';
                portfolioContainer.style.transform = 'translateY(0)';
            }, 300);
        }
    });
</script>
@endsection