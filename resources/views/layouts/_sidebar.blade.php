<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> 
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="{{ url('admin/dashboard') }}" 
        class="brand-link"> 
        @if(isset($company) && $company->logo)
            <img src="{{ asset($company->logo) }}" alt="{{ $company->name }}" 
                class="brand-image opacity-75 shadow"> 
        @else
            <img src="{{ asset('dist/assets/img/AdminLTELogo.png') }}" alt="Logo" 
                class="brand-image opacity-75 shadow"> 
        @endif
         <span class="brand-text fw-light">{{ isset($company) ? $company->short_name : 'POS' }}</span>  </a>  </div> 
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!--administrador-->
               @if(Auth::user()-> is_role == 1)
                <li class="nav-item menu-open"> <a href="{{url('admin/dashboard')}}" class="nav-link active"> <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Panel
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{url('admin/admin/list')}}" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                                <p>Administradores</p>
                            </a> </li>
                     
                    </ul>
                </li>
               
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>
                            Ingresos
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{url('admin/sales/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Factura de Venta</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{url('admin/accounts_receivable/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Cuentas X Cobrar</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{url('admin/quotation/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Cotizaciones</p>
                            </a> </li>
                            <li class="nav-item"> <a href="{{url('admin/orders/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Pedidos</p>
                            </a> </li>
                          
                      
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-clipboard-fill"></i>
                        <p>
                            Compras
                             <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{url('admin/purchase/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Listado</p>
                            </a> </li>
                            <li class="nav-item"> <a href="{{url('admin/purchase/create')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Nueva Compra</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{url('admin/accounts_payable/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Cuentas x  Pagar</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./layout/fixed-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Documento Soporte</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./layout/layout-custom-area.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Notas de Ajustes</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./layout/sidebar-mini.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Pagos</p>
                            </a> </li>
                    
                     
                      
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-clipboard-fill"></i>
                    <p>
                        Anulaciones
                         <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"> <a href="{{url('admin/notes_credit_debit/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p> Notas Debito -Credito </p>
                        </a> </li>
                      
                        <li class="nav-item"> <a href="{{url('admin/notes_concept/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p>Conceptos Notas</p>
                        </a> </li>

                                
                  
                </ul>
            </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-clipboard-fill"></i>
                    <p>
                        Orden de Compras
                         <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"> <a href="{{url('admin/status_order/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p>Estados Orden</p>
                        </a> </li>
                      
                  
                    <li class="nav-item"> <a href="{{url('admin/purchase_order/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p>Órdenes de Compra</p>
                        </a> </li>
                  
                </ul>
            </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                        <p>
                            Terceros
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                      
                        <li class="nav-item">
                             <a href="{{url('admin/person/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Mis Contáctos(Clientes-Proveedores)</p>
                            </a> </li>
                      
                       
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                    <p>
                        Configuración Items
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                
                        <li class="nav-item"> <a href="{{url('admin/items_type/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Tipo Items</p>
                            </a> </li>

                            <li class="nav-item"> <a href="{{url('admin/category/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Categorias</p>
                            </a> </li> 
                            <li class="nav-item"> <a href="{{url('admin/subcategory/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Sub Categorias</p>
                            </a> </li> 
                        <li class="nav-item"> <a href="{{url('admin/warehouse/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Bodegas</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{url('admin/brand/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Marcas</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{url('admin/measure/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Medidas</p>
                            </a> </li>
                            {{-- <li class="nav-item"> <a href="{{url('admin/invoice_group/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Grupo Contable</p>
                            </a> </li> --}}
                        
                    </ul>
                </li>
             
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                        <p>
                            Productos
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{url('admin/items/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p>Items de Venta</p>
                        </a> </li>
               
                        <li class="nav-item"> <a href="{{url('admin/category/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Categorias</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{url('admin/warehouse/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Bodegas</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{url('admin/brand/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Marcas</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{url('admin/measure/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Medidas</p>
                            </a> </li>
                            <li class="nav-item"> <a href="{{url('admin/list_price/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Lista de Precios</p>
                            </a> </li>
                            <li class="nav-item"> <a href="{{url('admin/colors/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Colores</p>
                            </a> </li>
                            <li class="nav-item"> <a href="{{url('admin/sizes/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Tamaños</p>
                            </a> </li>
                      
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                    <p>
                        Inventario
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    
                        <li class="nav-item">
                            <a href="{{url('admin/inventory/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Mi Inventario</p>
                            </a> </li>
                            <a href="{{url('admin/transfer/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Traslados</p>
                            </a> </li>
                            {{-- <li class="nav-item">
                                <a href="{{url('admin/adjustment_reason/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Motivo Ajuste</p>
                            </a> </li>
                            <li class="nav-item">
                                <a href="{{url('admin/inventory_ajusts/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Ajuste Inventario</p>
                            </a> </li> --}}
                            <li class="nav-item">
                                <a href="{{url('admin/inventory_value/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Valor Inventario</p>
                            </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/movements/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Movimientos Items</p>
                            </a> </li>
                    
                    
                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                    <p>
                        Activos Fjos
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    
                        <li class="nav-item">
                            <a href="{{url('admin/asset_category/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Categoria Activo</p>
                            </a> </li>
                            <a href="{{url('admin/asset_location/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Localizacion Activo</p>
                            </a> </li>
                            <li class="nav-item">
                                <a href="{{url('admin/asset/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Activo</p>
                            </a> </li>
                            <li class="nav-item">
                                <a href="{{url('admin/asset_history/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Histórico Activo</p>
                            </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/maintenance/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Mantenimientos</p>
                            </a> </li>
                    
                    
                    </ul>
                </li>


                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                    <p>
                        Contabilidad
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    
                        <li class="nav-item">
                           
                            </a> </li>
                            <a href="{{url('admin/puc-accounts')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Plan Contable</p>
                            </a> </li>
                            <li class="nav-item">
                                <a href="{{url('admin/receipt_type/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                    <p>Tipo Comprobantes</p>
                                </a> 
                            </li>


                    </ul>
                </li>
            
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                    <p>
                        Tesorería
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        <li class="nav-item">
                            <a href="{{url('admin/cash_register/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Cajas</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/type_movement_cash_register/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Tipo Movimientos </p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/cash_register_sessions/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Apertura de Cajas</p>
                            </a>
                        </li>
                        <li class="nav-item"></li>
                            <a href="{{url('admin/cash_movements/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Movimientos Caja</p>
                            </a>
                        </li>        

                    </ul>
                </li>
     

                {{-- <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-table"></i>
                        <p>
                            Comunicaciones
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="admin/communicate/send_email" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Enviar Correo</p>
                            </a> </li>
                    </ul>
                </li> --}}
                
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-table"></i>
                        <p>
                            Configuración
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                       
                        <li class="nav-item"> <a href="{{url('admin/company')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Mi Empresa</p>
                            </a> </li>
                     

                    </ul>
                </li>
                <!--Vendedor-->
                @elseif (Auth::user()->is_role== 2)
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                    <p>
                        Ingresos
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"> <a href="{{url('user/sales/list')}}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p>Factura de Ventas</p>
                        </a> </li>
                    <li class="nav-item"> <a href="./widgets/small-box.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p>Devolucion en ventas</p>
                        </a> </li>
                    <li class="nav-item"> <a href="./widgets/info-box.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p>Remisiones</p>
                        </a> </li>
                    <li class="nav-item"> <a href="./widgets/cards.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                            <p>Cotizaciones</p>
                        </a> </li>
                </ul>
            </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-clipboard-fill"></i>
                        <p>
                            Compras
                            <span class="nav-badge badge text-bg-secondary me-3">6</span> <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="./layout/unfixed-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Nuevo</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./layout/fixed-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Listado</p>
                            </a> </li>
                     
                        <li class="nav-item"> <a href="./layout/collapsed-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Orden de Compras</p>
                            </a> </li>
                            <li class="nav-item"> <a href="./layout/collapsed-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Pagos(Gastos)</p>
                            </a> </li>
                    
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                        <p>
                            Contactos
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="./UI/general.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Miembros</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./UI/icons.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Clientes</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./UI/timeline.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Proveedores</p>
                            </a> </li>
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                        <p>
                            Inventario
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="./forms/general.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>General Elements</p>
                            </a> </li>
                    </ul>
                </li>
        
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-table"></i>
                        <p>
                            Reportes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="./tables/simple.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Simple Tables</p>
                            </a> </li>
                           
                    </ul>
                </li>
            
            
                    @endif
               
            
            
                
         
             
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside>