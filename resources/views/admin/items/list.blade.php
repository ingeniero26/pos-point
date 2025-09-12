@extends('layouts.app')
  
    @section('content')
    @section('style')
    <style>
        .btn-group {
            display: inline-flex !important;
            gap: 5px;
        }
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        .table td {
            white-space: nowrap;
        }
        .table td:last-child {
            min-width: 150px;
        }
        .table td:nth-last-child(2) {
            min-width: 100px;
        }
        .dataTables_wrapper {
            overflow-x: auto;
        }
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            width: 100% !important;
        }
        .table th, .table td {
            padding: 0.5rem;
            vertical-align: middle;
        }
        .btn-group .btn {
            margin: 0 2px;
        }
        .status-btn {
            min-width: 32px;
        }
    </style>
    @endsection
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Productos</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Productos
                            </li>
                        </ol>
                    </div>
                </div> 
            </div> 
        </div>
        <div class="app-content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Productos</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addProductModal">
                                            Agregar Productos
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="product-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tipo</th>
                                                <th>Nombre</th>
                                                <th>Slug</th>
                                                <th>Cód. Barra</th>
                                                <th>Cód. Interno</th>
                                                <th>SKU</th>
                                                <th>Referencia</th>
                                                <th>Categoría</th>
                                                <th>Moneda</th>
                                                <th>Vencimiento</th>
                                                <th>Descripción</th>
                                                <th>Descripción Corta</th>
                                                <th>Adicional</th>
                                                <th>Retorno</th>
                                                <th>Marca</th>
                                                <th>Medida</th>
                                                <th>Grupo Inventario</th>
                                                <th>Precio Costo</th>
                                                <th>Precio Venta</th>
                                                <th>Ganancia</th>
                                                <th>% Ganancia (Valor)</th>
                                                <th>Impuesto</th>
                                                <th>Precio + IVA</th>
                                                <th>Estado</th>
                                                <th>Creado</th>
                                                <th>Actualizado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main> 
    {{-- modal crear  --}}
    <div class="flashMessage alert alert-success" style="display: none;"></div>
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" >
                        @csrf
                        <div class="row">
                          
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label"><b>Tipo Items</b></label>
                                    <select name="item_type_id" id="item_type_id" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach ($items_type as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                  
                                   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productName" class="form-label"><b>Nombre </b></label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="sku" class="form-label"><b>SKU </b></label>
                                    <input type="text" class="form-control" id="sku" name="sku" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="barcode" class="form-label"><b>Código de Barras </b></label>
                                    <input type="text" class="form-control" id="barcode" name="barcode"  onblur="duplicateBarcode(this)">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="manufacturer" class="form-label"><b>Código Interno </b></label>
                                    <input type="text" class="form-control" id="internal_code" name="internal_code"  onblur="duplicateInternalCode(this)">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="reference" class="form-label"><b>Referencia </b></label>
                                    <input type="text" class="form-control" id="reference" name="reference" >
                                </div>
                            </div>
                               <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Categoria</label>
                                     <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($categories as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                         </div> 
                          <div class="row">
                         
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label"><b>Descripción</b></label>
                                    <textarea class="summernote" name="description" id="description">
                                       
                                    </textarea>
                                    {{-- <textarea class="form-control" id="description" name="description" rows="3"></textarea> --}}
                                    </div>
    
                            </div>

                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description_short" class="form-label"><b>Descripción Corta</b></label>
                                    <textarea class="summernote" name="description_short" id="description_short">
                                       
                                    </textarea>                                    
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aditional_information" class="form-label"><b>Información Adicional</b></label>
                                    <textarea class="summernote" name="aditional_information" id="aditional_information">
                                       
                                    </textarea>                                    
                                </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="shipping_returns" class="form-label"><b>Retorno de envios</b></label>
                                    <textarea class="summernote" name="shipping_returns" id="shipping_returns">
                                       
                                    </textarea>                                    
                                </div>
                              </div>
                          </div>


                          <div class="row">
                              <div class="col-md-2">
                                <label for="">Moneda</label>
                                 <select name="currency_id" id="currency_id" class="form-control">
                                     <option value="">Seleccione</option>
                                       @foreach ($currencies as $key =>$item)
                                       {{-- <option value="{{$key }}">{{$item}}</option> --}}
                                       <option value="{{ $key }}" {{ $key == '170' ? 'selected' : '' }}>{{ $item }}</option>
                                           
                                       @endforeach
                                    </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">Fecha Vencimiento</label>
                                 <input type="date" class="form-control" id="expiration_date" name="expiration_date">
                            </div>
                            <div class="col-md-2">
                                <label for="">Maneja Serie</label>
                                <div class="form-check">
                                     <input type="checkbox" class="form-check-input" id="series_enabled"
                                      name="series_enabled" value="1" {{ old('series_enabled') == '1' ? 'checked' : '' }}>
                                     <label class="form-check-label" for="series_enabled">Maneja Serie</label>
                                 </div>
                            </div>
                            <div class="col-md-2">
                                <label for="">Maneja Lotes</label>
                                <div class="form-check">
                                     <input type="checkbox" class="form-check-input"
                                      id="batch_management" name="batch_management" value="1" {{ old('batch_management') == '1' ? 'checked' : '' }}>
                                     <label class="form-check-label" for="batch_management">Maneja Lotes</label>
                                 </div>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                                               
                          {{-- <div class="row">
                            <h3 class="text-center">Manejo de Lotes</h3>
                            <div class="col-md-6">
                                <label for=""> <b>Lotes</b> </label>
                                 <div class="form-check">
                                     <input type="checkbox" class="form-check-input" id="lots_enabled" name="lots_enabled">
                                     <label class="form-check-label" for="lots_enabled">Maneja Lotes</label>
                                 </div>
     
                            </div>
                            <div class="col-md-6">
                                <label for="">Digite el codigo del lote</label>
                                 <input type="text" class="form-control" id="lot_code" name="lot_code">
                                 <button type="button" class="btn btn-primary btn-sm" id="addLotButton">Agregar</button>
                            </div>
                          </div> --}}
                          </div>
                          <div class="row">
                        
                        
                            <hr>
                            <div class="row" id='inventory_hide'>
                                 <h3 class="text-center">Detalle Inventario</h3>
                                <div class="col-md-3" id="warehouse_field">
                                    <label for="" class="form-label"><b>Bodega</b></label>
                                    <select name="warehouse_id" id="warehouse_id" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach ($warehouses as $key =>$item)
                                        <option value="{{$key }}">{{$item}}</option>
                                            
                                        @endforeach
                                        </select>
                                </div>
                                <div class="col-md-3" id="quantity_field">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label"><b>Cantidad</b></label>
                                        <input type="number" class="form-control" id="stock" name="stock">
                                    </div>
                                </div>
                                <div class="col-md-2" id="min_quantity_field">
                                    <div class="mb-3">
                                        <label for="min_quantity" class="form-label"><b>Cantidad Mínima</b></label>
                                        <input type="number" class="form-control" id="min_quantity" name="min_quantity" >
                                    </div>
                                </div> 
                                <div class="col-md-2" id="max_quantity_field">
                                    <label for="">Cantidad Maxima</label>
                                     <input type="number" class="form-control" id="max_quantity" name="max_quantity" >
                                </div>
                                 <div class="col-md-2" id="reorder_level_field">
                                    <label for="">Reposición</label>
                                     <input type="number" class="form-control" id="reorder_level" name="reorder_level" >
                                </div>
                            </div>
                           
                        <div class="row">
                            <hr>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="reorder_level" class="form-label"><b>Marca</b></label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($brands as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="reorder_level" class="form-label"><b>Medida</b></label>
                                    <select name="measure_id" id="measure_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($measures as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="invoice_group_id" class="form-label"><b>Grupo Inventario</b></label>
                                    <select name="invoice_group_id" id="invoice_group_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($invoice_groups as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cost_price" class="form-label"><b>Precio de Costo</b></label>
                                    <input type="number" class="form-control" id="cost_price" name="cost_price" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label"><b>Impuesto</b></label>
                                <select name="tax_id" id="tax_id" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach ($taxes as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            
                            <div class="row">
                                <!-- Campo para el precio sin impuesto -->
                                <div class="col-md-4">
                                    <label for="" class="form-label"><b>Precio sin Impuesto</b></label>
                                    <input type="number" name="selling_price" id="selling_price" class="form-control" step="0.01">
                                </div>

                                <!-- Campo para el precio con impuesto -->
                                <div class="col-md-4">
                                    <label for="" class="form-label"><b>Precio Final (con Impuesto)</b></label>
                                    <input type="number" name="price_total" id="price_total" class="form-control" step="0.01" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="percentage_profit" class="form-label"><b>% Ganancia</b></label>
                                    <input type="text" id="percentage_profit" name="percentage_profit" class="form-control" readonly>
                                </div>
                            </div>
                         
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> <span id="product_name"></span></p>
                <p><strong>Descripción:</strong> <span id="barcode"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
          
    @endsection
   @section('script')
   
   <script type="text/javascript">
    $(function () {
    // Summernote
    $('.summernote').summernote()

    // // CodeMirror
    // CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
    //   mode: "htmlmixed",
    //   theme: "monokai"
    // });
  });
    
    // Variable global para controlar el estado de envío
    let isSubmitting = false;

    $(document).ready(function(){
         
    // select2
  
        let dataTable = $("#product-table").DataTable({
            "processing": true,
            "serverSide": false,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "ordering": true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "processing": "Procesando...",
                "loadingRecords": "Cargando...",
                "searchPlaceholder": "Buscar en todos los campos..."
            },
            "buttons": [
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copiar',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':visible:not(:last-child)'
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':visible:not(:last-child)'
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':visible:not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':visible:not(:last-child)'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':visible:not(:last-child)'
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-columns"></i> Columnas',
                    className: 'btn btn-secondary btn-sm'
                }
            ],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                   "<'row'<'col-sm-12'tr>>" +
                   "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                   "<'row'<'col-sm-12'B>>",
            "order": [[0, 'asc']],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false
                },
                {
                    "targets": [-1],
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center"
                },
                {
                    "targets": "_all",
                    "className": "align-middle"
                }
            ],
            "drawCallback": function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        }).buttons().container().appendTo('#product-table_wrapper .col-md-6:eq(0)');

        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', { 
                style: 'currency', 
                currency: 'COP',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(value);
        }

        function loadProducts() {
            $.ajax({
                url: "{{route('product.fetch')}}",
                type: 'GET',
                beforeSend: function() {
                    $('#product-table tbody').html('<tr><td colspan="21" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>');
                },
                success: function(response) {
                    if ($.fn.DataTable.isDataTable('#product-table')) {
                        $('#product-table').DataTable().destroy();
                    }

                    $('#product-table tbody').empty();

                    response.forEach(function(items) {
                        let createdAt = dayjs(items.created_at).format('DD/MM/YYYY h:mm A');
                        let updatedAt = dayjs(items.updated_at).format('DD/MM/YYYY h:mm A');
                        let costPrice = formatCurrency(items.cost_price);
                        let sellingPrice = formatCurrency(items.selling_price);
                        let price_total = formatCurrency(items.price_total);
                        let statusText = items.status == 1 ? 'Inactivo' : 'Activo';
                        let statusClass = items.status == 1 ? 'badge bg-danger' : 'badge bg-success';
                        let ganancia = (items.selling_price)-(items.cost_price);
                        let percentageProfit = formatCurrency(items.percentage_profit);
                        
                       
                        
                        let row = `
                            <tr>
                                <td>${items.id}</td>
                                <td>${items.items_type ? items.items_type.name : 'N/A'}</td>
                                <td>${items.product_name}</td>
                                <td>${items.slug || 'N/A'}</td>
                                <td>${items.barcode || 'N/A'}</td>
                                <td>${items.internal_code || 'N/A'}</td>
                                <td>${items.sku || 'N/A'}</td>
                                <td>${items.reference || 'N/A'}</td>
                                <td>${items.category ? items.category.category_name : 'N/A'}</td>
                                <td>${items.currencies ? items.currencies.currency_name : 'N/A'}</td>
                                <td>${items.expiration_date || 'N/A'}</td>
                                <td>${items.description || 'N/A'}</td>
                                <td>${items.description_short || 'N/A'}</td>
                                <td>${items.aditional_information || 'N/A'}</td>
                                <td>${items.shipping_returns || 'N/A'}</td>
                                <td>${items.brand ? items.brand.brand_name : 'N/A'}</td>
                                <td>${items.measure ? items.measure.measure_name : 'N/A'}</td>
                                <td>${items.invoice_groups ? items.invoice_groups.name : 'N/A'}</td>
                                <td class="text-end">${costPrice}</td>
                                <td class="text-end">${sellingPrice}</td>
                                <td class="text-end">${ganancia}</td>
                                <td class="text-end">${percentageProfit || 'N/A'}%</td>
                                <td>${items.tax ? items.tax.tax_name : 'N/A'}</td>
                                <td class="text-end">${price_total}</td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm status-btn ${items.status == 1 ? 'btn-danger' : 'btn-success'}" 
                                            data-id="${items.id}" 
                                            data-status="${items.status}"
                                            data-bs-toggle="tooltip" 
                                            title="${items.status == 1 ? 'Activar' : 'Desactivar'}">
                                        <i class="fas ${items.status == 1 ? 'fa-times' : 'fa-check'}"></i>
                                    </button>
                                </td>
                                <td>${createdAt}</td>
                                <td>${updatedAt}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-warning btn-sm edit-btn" 
                                                data-id="${items.id}" 
                                                data-bs-toggle="tooltip" 
                                                title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-info btn-sm view-info" 
                                                data-id="${items.id}" 
                                                data-bs-toggle="tooltip" 
                                                title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm delete-btn" 
                                                data-id="${items.id}" 
                                                data-bs-toggle="tooltip" 
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        $('#product-table tbody').append(row);
                    });

                    // Reinicializar DataTable
                    dataTable = $("#product-table").DataTable({
                        "processing": true,
                        "serverSide": false,
                        "responsive": true,
                        "scrollX": true,
                        "lengthChange": true,
                        "autoWidth": false,
                        "ordering": true,
                        "language": {
                            "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                        },
                        "buttons": [
                            {
                                extend: 'copy',
                                text: '<i class="fas fa-copy"></i> Copiar',
                                className: 'btn btn-secondary btn-sm',
                                exportOptions: {
                                    columns: ':visible:not(:last-child)'
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fas fa-file-csv"></i> CSV',
                                className: 'btn btn-secondary btn-sm',
                                exportOptions: {
                                    columns: ':visible:not(:last-child)'
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fas fa-file-excel"></i> Excel',
                                className: 'btn btn-secondary btn-sm',
                                exportOptions: {
                                    columns: ':visible:not(:last-child)'
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fas fa-file-pdf"></i> PDF',
                                className: 'btn btn-secondary btn-sm',
                                exportOptions: {
                                    columns: ':visible:not(:last-child)'
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="fas fa-print"></i> Imprimir',
                                className: 'btn btn-secondary btn-sm',
                                exportOptions: {
                                    columns: ':visible:not(:last-child)'
                                }
                            },
                            {
                                extend: 'colvis',
                                text: '<i class="fas fa-columns"></i> Columnas',
                                className: 'btn btn-secondary btn-sm'
                            }
                        ],
                        "pageLength": 10,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                               "<'row'<'col-sm-12'tr>>" +
                               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                               "<'row'<'col-sm-12'B>>",
                        "order": [[0, 'asc']],
                        "columnDefs": [
                            {
                                "targets": [0],
                                "visible": false
                            },
                            {
                                "targets": [-1],
                                "orderable": false,
                                "searchable": false,
                                "className": "text-center",
                                "width": "150px"
                            },
                            {
                                "targets": [-2],
                                "orderable": false,
                                "searchable": false,
                                "className": "text-center",
                                "width": "100px"
                            },
                            {
                                "targets": "_all",
                                "className": "align-middle"
                            }
                        ],
                        "initComplete": function() {
                            // Ajustar columnas después de la inicialización
                            this.api().columns.adjust();
                        },
                        "drawCallback": function() {
                            // Reinicializar tooltips
                            $('[data-bs-toggle="tooltip"]').tooltip();
                            
                            // Agregar eventos a los botones
                            $(document).off('click', '.edit-btn').on('click', '.edit-btn', handleEdit);
                            $(document).off('click', '.view-info').on('click', '.view-info', handleView);
                            $(document).off('click', '.delete-btn').on('click', '.delete-btn', handleDelete);
                            $(document).off('click', '.status-btn').on('click', '.status-btn', handleStatusChange);

                            // Ajustar columnas después de cada redibujado
                            this.api().columns.adjust();
                        }
                    }).buttons().container().appendTo('#product-table_wrapper .col-md-6:eq(0)');
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los productos:', error);
                    $('#product-table tbody').html('<tr><td colspan="21" class="text-center text-danger"><i class="fas fa-exclamation-circle"></i> Error al cargar los datos</td></tr>');
                }
            });
        }

        // Cargar productos al iniciar
        loadProducts();

        // Función para recargar los productos
        window.reloadProducts = function() {
            loadProducts();
        };

        // Agregar el evento click al documento para manejar los botones de editar
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();
            handleEdit.call(this, e);
        });

        // Modificar el evento submit del formulario para manejar tanto creación como edición
        $('#addProductForm').on('submit', function(e) {
            e.preventDefault();
            
            // Prevenir envío duplicado
            if (isSubmitting) {
                return false;
            }
            
            isSubmitting = true;
            let submitButton = $(this).find('button[type="submit"]');
            submitButton.prop('disabled', true);

            const editId = $(this).data('edit-id');
            const url = editId ? 
                "{{ url('admin/items/update') }}/" + editId : 
                "{{ route('items.store') }}";
            const method = editId ? 'POST' : 'POST';
            
            $.ajax({
                url: url,
                type: method,
                data: $(this).serialize(),
                success: function(response) {
                    $('#addProductModal').modal('hide');
                    $('#addProductForm')[0].reset();
                    $('#addProductForm').removeData('edit-id');
                    $('#addProductModalLabel').text('Agregar Producto');
                    $('.modal-footer button[type="submit"]').text('Agregar');
                    
                    Swal.fire({
                        title: '¡Éxito!',
                        text: editId ? 'Producto actualizado exitosamente' : 'Producto creado exitosamente',
                        icon: 'success'
                    });
                    
                    loadProducts(); // Recargar la tabla
                },
                error: function(xhr, status, error) {
                    console.error('Error al guardar el producto:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar el producto: ' + (xhr.responseJSON?.error || error)
                    });
                },
                complete: function() {
                    // Asegurarse de que el flag se resetee después de un tiempo
                    setTimeout(function() {
                        isSubmitting = false;
                        submitButton.prop('disabled', false);
                    }, 2000);
                }
            });
        });

        function handleEdit(e) {
            e.preventDefault();
            let productId = $(this).data('id');
           // console.log('Editando producto:', productId); // Debug log
            
            // Mostrar indicador de carga
            Swal.fire({
                title: 'Cargando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ url('admin/items/edit') }}/" + productId,
                type: 'GET',
                success: function(product) {
                    // Cerrar el indicador de carga
                    Swal.close();

                    // Establecer los valores en los campos del modal
                    $('#item_type_id').val(product.item_type_id);
                    $('#product_name').val(product.product_name);
                    $('#barcode').val(product.barcode);
                    $('#internal_code').val(product.internal_code);
                    $('#sku').val(product.sku);
                    $('#reference').val(product.reference);
                    $('#category_id').val(product.category_id);
                    $('#brand_id').val(product.brand_id);
                    $('#measure_id').val(product.measure_id);
                    $('#cost_price').val(product.cost_price);
                    $('#selling_price').val(product.selling_price);
                    $('#tax_id').val(product.tax_id);
                    $('#price_total').val(product.price_total);
                    $('#description').val(product.description);
                    $('#currency_id').val(product.currency_id);
                    $('#expiration_date').val(product.expiration_date);
                    
                    // Cambiar el título del modal y el texto del botón
                    $('#addProductModalLabel').text('Editar Producto');
                    $('.modal-footer button[type="submit"]').text('Actualizar');
                    
                    // Agregar el ID del producto al formulario
                    $('#addProductForm').data('edit-id', productId);
                    
                    // Mostrar el modal
                    $('#addProductModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Cerrar el indicador de carga
                    Swal.close();
                    
                    console.error('Error al cargar el producto:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la información del producto: ' + (xhr.responseJSON?.error || error)
                    });
                }
            });
        }

        function handleDelete(e) {
            e.preventDefault();
            const productId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente el producto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/items/delete') }}/" + productId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: 'El producto ha sido eliminado exitosamente.',
                                icon: 'success'
                            });
                            loadProducts(); // Recargar la tabla
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar el producto:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo eliminar el producto'
                            });
                        }
                    });
                }
            });
        }

        function handleStatusChange(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            const currentStatus = $(this).data('status');
            const newStatus = currentStatus == 1 ? 0 : 1;

            $.ajax({
                url: "{{ url('admin/items/toggle-status') }}/" + productId,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: newStatus
                },
                success: function(response) {
                    Swal.fire({
                        title: '¡Estado actualizado!',
                        text: 'El estado del producto ha sido actualizado exitosamente.',
                        icon: 'success'
                    });
                    loadProducts(); // Recargar la tabla
                },
                error: function(xhr, status, error) {
                    console.error('Error al cambiar el estado:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cambiar el estado del producto'
                    });
                }
            });
        }

        function handleView(e)
        {
            e.preventDefault(); 
            const itemId = $(this).data('id'); 
            window.location.href = "{{ url('admin/items') }}/" + itemId;
        }
    });
</script>

<script type="text/javascript">
 // funcion duplicado barcode 
 function duplicateBarcode(input) {
    var barcode  = input.value;
        if (barcode) {
        $.ajax({
         url: '{{ url('admin/items/check-barcode') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
             barcode: barcode
            },
                        success: function(response) {
                            if (response.exists) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ya existe un producto con este codigo de barras.'
                                }).then(() => {
                                    input.value = '';
                                });
                            }
                        }
                    });
                }
            }
            // funcion duplicado internal code 
    function duplicateInternalCode(input) {
        var internalCode = input.value;
                if (internalCode) {
                    $.ajax({
                        url: '{{ url('admin/items/check-internal-code') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            internal_code: internalCode
                        },
                        success: function(response) {
                            if (response.exists) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ya existe un producto con este codigo interno.'
                                }).then(() => {
                                    input.value = '';
                                });
                            }
                        }
                    });
                }
            }
            
            
                        
            
    $(document).ready(function(){
        let isSubmitting = false; // Flag para controlar el envío

        $('#tax_id').change(function() {
            var taxId = $(this).val();
            var sellingPrice = parseFloat($('#selling_price').val());

            if (taxId && sellingPrice) {
                $.ajax({
                    url: "{{ url('admin/tax') }}/" + taxId,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response) {
                        var taxRate = response.rate;
                        var priceTotal = sellingPrice + (sellingPrice * taxRate / 100);
                        $('#price_total').val(priceTotal.toFixed(2));
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener la tarifa del impuesto: ', error);
                    }
                });
            } else {
                $('#price_total').val(sellingPrice.toFixed(2));
            }
        });

        $('#selling_price').on('input', function() {
            var sellingPrice = parseFloat($(this).val());
            var taxId = $('#tax_id').val();
            var costPrice = parseFloat($('#cost_price').val()) || 0;
    var porcentajeGanancia = 0;

    if (costPrice > 0) {
        porcentajeGanancia = ((sellingPrice - costPrice) / costPrice) * 100;
    }

    $('#percentage_profit').val(porcentajeGanancia.toFixed(2)); // Muestra el resultado en un input

            if (taxId && sellingPrice) {
                $.ajax({
                    url: "{{ url('admin/tax') }}/" + taxId,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response) {
                        var taxRate = response.rate;
                        var priceTotal = sellingPrice + (sellingPrice * taxRate / 100);
                        $('#price_total').val(priceTotal.toFixed(2));
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener la tarifa del impuesto: ', error);
                    }
                });
            } else {
                $('#price_total').val(sellingPrice.toFixed(2));
            }
        });
    });
    // select2
    
    

</script>


@endsection


                                        
   