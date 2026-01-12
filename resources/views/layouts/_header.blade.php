<nav class="app-header navbar navbar-expand bg-body"> 
    <div class="container-fluid"> 
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
            <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Conf. Contabilidad
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
                    Conf. Tesoreria
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
               <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Conf. Nómina
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                 
                    <li > <a href="{{url('admin/eps/list')}}" class="dropdown-item">
                        
                       EPS
                    </a> </li>
                    <li> <a href="{{url('admin/pensions/list')}}"class="dropdown-item">
                        Fondo de Pensiones
                    </a> </li>
                
                    <li> <a href="{{url('admin/arl_providers/list')}}"class="dropdown-item">
                        ARL
                    </a> </li>

                        <li> <a href="{{url('admin/areas/list')}}"class="dropdown-item">
                            Areas de la Empresa
                        </a> </li>
                    <li><a href="{{url('admin/positions/list')}}"class="dropdown-item">
                        Cargos
                    </a> </li>
                </ul>
              </div>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Contratos
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                 
                    <li > <a href="{{url('admin/eps/list')}}" class="dropdown-item">
                        
                       Tipo de Contrato
                    </a> </li>
                    
                </ul>
              </div>
               {{-- <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    CRM
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                 
                    <li > <a href="{{url('admin/contact_types/list')}}" class="dropdown-item">
                        
                       Tipo Contactos
                    </a> </li>
                   
                    <li> <a href="{{url('admin/contact_sources/list')}}"class="dropdown-item">
                        Fuentes de Contactos
                    </a> </li>
                    <li> <a href="{{url('admin/opportunity_stages/list')}}"class="dropdown-item">
                        Etapas de Oportunidades
                    </a> </li>
                    <li> <a href="{{url('admin/opportunity_priority/list')}}"class="dropdown-item">
                        Prioridades
                    </a> </li>
                    
                    <li>
                        <a href="{{url('admin/opportunity_state/list')}}"class="dropdown-item">
                           Estados de Oportunidades
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/opportunities')}}"class="dropdown-item">
                            Oportunidades
                        </a>    
                    </li>
                </ul>
              </div> --}}

        </ul> 
        <ul class="navbar-nav ms-auto">
           
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