@extends('home.layouts.app')
@section('style')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    .contact-modern {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .page-title.modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .page-title.modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .page-title h1 {
        font-weight: 700;
        font-size: 3.5rem;
        letter-spacing: -2px;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
    
    .page-title p {
        font-size: 1.2rem;
        opacity: 0.9;
        font-weight: 300;
        line-height: 1.6;
    }
    
    .breadcrumbs ol li a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .breadcrumbs ol li a:hover {
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .contact-section-modern {
        padding: 80px 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        position: relative;
    }
    
    .info-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    
    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }
    
    .info-card i {
        font-size: 3rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 20px;
        display: block;
    }
    
    .info-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }
    
    .info-card p {
        color: #718096;
        font-size: 1rem;
        line-height: 1.6;
        margin: 0;
        font-weight: 500;
    }
    
    .contact-form-modern {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .contact-form-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .form-control-modern {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        background: #f8fafc;
        color: #2d3748;
    }
    
    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }
    
    .form-control-modern::placeholder {
        color: #a0aec0;
        font-weight: 400;
    }
    
    .btn-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 15px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }
    
    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .map-container iframe {
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    
    .loading-modern, .error-message-modern, .sent-message-modern {
        padding: 15px;
        border-radius: 12px;
        margin: 15px 0;
        font-weight: 500;
        text-align: center;
    }
    
    .loading-modern {
        background: #e6fffa;
        color: #234e52;
        border: 1px solid #81e6d9;
    }
    
    .error-message-modern {
        background: #fed7d7;
        color: #742a2a;
        border: 1px solid #fc8181;
    }
    
    .sent-message-modern {
        background: #c6f6d5;
        color: #22543d;
        border: 1px solid #68d391;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .section-title h2 {
        font-size: 3rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 20px;
        letter-spacing: -2px;
    }
    
    .section-title p {
        font-size: 1.2rem;
        color: #718096;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }
    
    @media (max-width: 768px) {
        .page-title h1 {
            font-size: 2.5rem;
        }
        
        .contact-form-modern, .info-card {
            padding: 30px 20px;
        }
        
        .section-title h2 {
            font-size: 2rem;
        }
    }
</style>
@endsection
@section('content')
 <main class="main contact-modern">
     <!-- Page Title -->
    <div class="page-title modern dark-background">
      <div class="container position-relative">
        <h1>📞 Contáctanos</h1>
        <p>Estamos aquí para ayudarte. Ponte en contacto con nosotros y te responderemos lo antes posible con la mejor atención personalizada.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('home') }}">🏠 Inicio</a></li>
            <li class="current">📞 Contacto</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->
     <!-- Contact Section -->
    <section id="contact" class="contact-section-modern">
      <div class="container">
        <div class="section-title" data-aos="fade-up">
          <h2>💬 Hablemos</h2>
          <p>Múltiples formas de conectar contigo. Elige la que más te convenga y comencemos una conversación.</p>
        </div>

        <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-6">
            <div class="row gy-4">

              <div class="col-lg-12">
                <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                  <i class="bi bi-geo-alt"></i>
                  <h3>📍 Nuestra Ubicación</h3>
                  <p>Calle Principal #123<br>Centro Empresarial<br>Ciudad, País 12345</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-card" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-telephone"></i>
                  <h3>📞 Llámanos</h3>
                  <p>+57 (1) 234 5678<br>+57 300 123 4567</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-card" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-envelope"></i>
                  <h3>✉️ Escríbenos</h3>
                  <p>info@empresa.com<br>soporte@empresa.com</p>
                </div>
              </div><!-- End Info Item -->

            </div>
          </div>

          <div class="col-lg-6">
            <div class="contact-form-modern" data-aos="fade-up" data-aos-delay="500">
              <h3 style="margin-bottom: 30px; color: #1a202c; font-weight: 600;">💌 Envíanos un Mensaje</h3>
              <form action="forms/contact.php" method="post" class="php-email-form">
                <div class="row gy-4">

                  <div class="col-md-6">
                    <label for="name" style="display: block; margin-bottom: 8px; color: #4a5568; font-weight: 500;">👤 Nombre Completo</label>
                    <input type="text" name="name" class="form-control form-control-modern" placeholder="Ingresa tu nombre completo" required="">
                  </div>

                  <div class="col-md-6">
                    <label for="email" style="display: block; margin-bottom: 8px; color: #4a5568; font-weight: 500;">📧 Correo Electrónico</label>
                    <input type="email" class="form-control form-control-modern" name="email" placeholder="tu@email.com" required="">
                  </div>

                  <div class="col-md-12">
                    <label for="subject" style="display: block; margin-bottom: 8px; color: #4a5568; font-weight: 500;">📋 Asunto</label>
                    <input type="text" class="form-control form-control-modern" name="subject" placeholder="¿En qué podemos ayudarte?" required="">
                  </div>

                  <div class="col-md-12">
                    <label for="message" style="display: block; margin-bottom: 8px; color: #4a5568; font-weight: 500;">💬 Mensaje</label>
                    <textarea class="form-control form-control-modern" name="message" rows="6" placeholder="Cuéntanos más detalles sobre tu consulta..." required=""></textarea>
                  </div>

                  <div class="col-md-12 text-center">
                    <div class="loading loading-modern" style="display: none;">
                      🔄 Enviando mensaje...
                    </div>
                    <div class="error-message error-message-modern" style="display: none;">
                      ❌ Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.
                    </div>
                    <div class="sent-message sent-message-modern" style="display: none;">
                      ✅ ¡Tu mensaje ha sido enviado exitosamente! Te responderemos pronto.
                    </div>

                    <button type="submit" class="btn-modern">
                      🚀 Enviar Mensaje
                    </button>
                  </div>

                </div>
              </form>
            </div>
          </div><!-- End Contact Form -->

        </div>

        <!-- Additional Contact Info -->
        <div class="row mt-5" data-aos="fade-up" data-aos-delay="600">
          <div class="col-12">
            <div class="info-card" style="padding: 40px; text-align: left;">
              <div class="row">
                <div class="col-md-3 text-center mb-4 mb-md-0">
                  <i class="bi bi-clock" style="font-size: 2.5rem; margin-bottom: 15px;"></i>
                  <h4 style="color: #1a202c; font-weight: 600; margin-bottom: 10px;">🕒 Horarios</h4>
                  <p style="margin: 0; color: #718096;">
                    <strong>Lunes - Viernes:</strong><br>8:00 AM - 6:00 PM<br>
                    <strong>Sábados:</strong><br>9:00 AM - 2:00 PM<br>
                    <strong>Domingos:</strong><br>Cerrado
                  </p>
                </div>
                <div class="col-md-3 text-center mb-4 mb-md-0">
                  <i class="bi bi-headset" style="font-size: 2.5rem; margin-bottom: 15px;"></i>
                  <h4 style="color: #1a202c; font-weight: 600; margin-bottom: 10px;">🎧 Soporte</h4>
                  <p style="margin: 0; color: #718096;">
                    <strong>Chat en línea:</strong><br>24/7 disponible<br>
                    <strong>Soporte técnico:</strong><br>Lun-Vie 8AM-8PM
                  </p>
                </div>
                <div class="col-md-3 text-center mb-4 mb-md-0">
                  <i class="bi bi-share" style="font-size: 2.5rem; margin-bottom: 15px;"></i>
                  <h4 style="color: #1a202c; font-weight: 600; margin-bottom: 10px;">🌐 Redes Sociales</h4>
                  <div style="display: flex; justify-content: center; gap: 15px; margin-top: 15px;">
                    <a href="#" style="color: #667eea; font-size: 1.5rem; transition: all 0.3s ease;"><i class="bi bi-facebook"></i></a>
                    <a href="#" style="color: #667eea; font-size: 1.5rem; transition: all 0.3s ease;"><i class="bi bi-twitter"></i></a>
                    <a href="#" style="color: #667eea; font-size: 1.5rem; transition: all 0.3s ease;"><i class="bi bi-instagram"></i></a>
                    <a href="#" style="color: #667eea; font-size: 1.5rem; transition: all 0.3s ease;"><i class="bi bi-linkedin"></i></a>
                  </div>
                </div>
                <div class="col-md-3 text-center">
                  <i class="bi bi-shield-check" style="font-size: 2.5rem; margin-bottom: 15px;"></i>
                  <h4 style="color: #1a202c; font-weight: 600; margin-bottom: 10px;">🛡️ Privacidad</h4>
                  <p style="margin: 0; color: #718096;">
                    Tus datos están seguros<br>con nosotros. Cumplimos<br>con todas las normativas<br>de protección de datos.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="container mt-5" data-aos="fade-up" data-aos-delay="700">
        <div class="map-container">
          <iframe style="border:0; width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div><!-- End Google Maps -->

    </section><!-- /Contact Section -->

</main>
@endsection
@section('script')
@endsection