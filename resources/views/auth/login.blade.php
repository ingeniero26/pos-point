<!DOCTYPE html>
<html lang="en"> 

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ADMIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Login Page">
    <meta name="author" content="JERSON BATISTA">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}">
</head> 

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="login-logo"> <a href=""><b>POS-</b>SYSTEM</a> </div> 
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ingreso al sistema</p>
                @include('_message')
                <form action="{{url('login_post')}}" method="post">
                    {{csrf_field()}}
                    <div class="input-group mb-3"> 
                        <input type="email" name="email" value="{{old('email')}}" required class="form-control" placeholder="Email">
                        <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>
                    </div>
                    <div class="input-group mb-3">
                         <input type="password" required name="password" value="{{ old('password')}}" class="form-control" placeholder="Password">
                        <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                    Remember Me
                                </label> </div>
                        </div> 
                        <div class="col-4">
                            <div class="d-grid gap-2">
                                 <button type="submit" class="btn btn-primary">Ingresar</button> </div>
                        </div> 
                    </div>
                </form>
                <p class="mb-1">
                    <a href="{{ url('forgot-password') }}">Recuperar clave</a>
                </p>
                <p class="mb-1">
                    <a href="{{ url('register') }}">Registrar usuario</a>
                </p>
            
            </div> 
        </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" ></script> 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" ></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" ></script> 
    <script src="{{asset('dist/js/adminlte.js')}}"></script> 
   
</body>

</html>