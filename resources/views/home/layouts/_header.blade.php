  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">Moderna</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{url('/home')}}" class="active">Inicio</a></li>
          <li><a href="{{url('/about')}}">Nosotros</a></li>
          <li><a href="{{url('/services')}}">Servicios</a></li>
          <li><a href="{{url('/portfolio')}}">Portfolio</a></li>
          <li><a href="{{url('/team')}}">Team</a></li>
          <li><a href="{{url('/blog')}}">Blog</a></li>
          <li><a href="{{url('/contact')}}">Contacto</a></li> 
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>