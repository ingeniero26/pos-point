<nav class="app-header navbar navbar-expand bg-body"> 
    <div class="container-fluid"> 
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
            <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Configuración Contabilidad
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="{{url('admin/bank/list')}}">Entidades Bancarias</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/cost_center/list')}}">Centro de Costos</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/account_document_type/list')}}">Tipo Documento Contables</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/account_document_source/list')}}">Fuentes  Contables</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/account/list')}}">Cuentas Contables</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/tax/list')}}">Impuestos(IVA)</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/type_regimen/list')}}">Tipo Régimen</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/type_liability/list')}}">Tipo Obligación Tributaria</a></li>
                </ul>
            </div>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Configuración Tesoreria
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="{{url('admin/payment_method/list')}}">Métodos de Pago</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/payment_type/list')}}">Tipo de Pago</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/bank/list')}}">Bancos</a></li>
                  <li><a class="dropdown-item" href="{{url('admin/account_plan/list')}}">Cuentas Bancarias</a></li>

                </ul>
              </div>
              <br>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    General
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                 
                    <li > <a href="{{url('admin/identification_type/list')}}" class="dropdown-item">
                        
                       Tipo Identificación
                    </a> </li>
                    <li > <a href="{{url('admin/department/list')}}" class="dropdown-item">Departamentos
                    </a> </li>
                    <li> <a href="{{url('admin/city/list')}}"class="dropdown-item">
                        Ciudades
                    </a> </li>
                    <li> <a href="{{url('admin/branch_type/list')}}"class="dropdown-item">
                        Tipo Sucursal
                    </a> </li>
                    <li> <a href="{{url('admin/branch/list')}}"class="dropdown-item">
                        Sucursales
                    </a> </li>
                </ul>
              </div>

        </ul> 
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i class="bi bi-search"></i> </a> </li> <!--end::Navbar Search--> <!--begin::Messages Dropdown Menu-->
            <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i class="bi bi-chat-text"></i> <span class="navbar-badge badge text-bg-danger">3</span> </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <a href="#" class="dropdown-item"> <!--begin::Message-->
                        <div class="d-flex">
                            <div class="flex-shrink-0"> <img src="../../dist/assets/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                                </h3>
                                <p class="fs-7">Call me whenever you can...</p>
                                <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div> 
                    </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <!--begin::Message-->
                        <div class="d-flex">
                            <div class="flex-shrink-0"> <img src="../../dist/assets/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-end fs-7 text-secondary"> <i class="bi bi-star-fill"></i> </span>
                                </h3>
                                <p class="fs-7">I got your message bro</p>
                                <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div> <!--end::Message-->
                    </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <!--begin::Message-->
                        <div class="d-flex">
                            <div class="flex-shrink-0"> <img src="../../dist/assets/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-end fs-7 text-warning"> <i class="bi bi-star-fill"></i> </span>
                                </h3>
                                <p class="fs-7">The subject goes here</p>
                                <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div> <!--end::Message-->
                    </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li> <!--end::Messages Dropdown Menu--> <!--begin::Notifications Dropdown Menu-->
 
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <img src="../../dist/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image"> <span class="d-none d-md-inline">{{Auth::user()->name}}  {{Auth::user()->last_name}}</span> </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                    <li class="user-header text-bg-primary"> <img src="../../dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{Auth::user()->email}}
                            <small>Member since Nov. 2023</small>
                        </p>
                    </li> 
                    <li class="user-body"> 
                        <div class="row">
                            <div class="col-4 text-center"> <a href="#">Inventario</a> </div>
                            <div class="col-4 text-center"> <a href="#">Ventas</a> </div>
                            <div class="col-4 text-center"> <a href="#">Compras</a> </div>
                        </div> 
                    </li> 
                    <li class="user-footer"> <a href="#" class="btn btn-default btn-flat">Perfil</a> 
                        <a href="{{url('logout')}}" class="btn btn-default btn-flat float-end">
                            Salir</a> </li> <!--end::Menu Footer-->
                </ul>
            </li> 
        </ul> 
    </div> 
</nav> 