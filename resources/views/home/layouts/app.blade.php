<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - Moderna Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{url('frontend/img/favicon.png')}}" rel="icon">
  <link href="{{url('frontend/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{url('frontend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{url('frontend/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{url('frontend/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{url('frontend/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{url('frontend/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{url('frontend/css/main.css')}}" rel="stylesheet">

   @yield('style')
</head>

<body class="index-page">
    <!-- Header -->
    @include('home.layouts._header')
    @yield('content')
    


    <!-- Footer -->
    @include('home.layouts._footer')


    <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{url('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{url('frontend/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{url('frontend/vendor/aos/aos.js')}}"></script>
  <script src="{{url('frontend/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{url('frontend/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{url('frontend/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{url('frontend/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{url('frontend/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{url('frontend/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{url('frontend/vendor/waypoints/noframework.waypoints.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{url('frontend/js/main.js')}}"></script>
  @yield('script')

</body>

</html>