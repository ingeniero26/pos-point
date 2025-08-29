@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Pedidos</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pedidos
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content-body">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Filtros de búsqueda</h5>
                            <button class="btn btn-sm btn-link float-end" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                                <i class="fas fa-filter"></i> Mostrar/Ocultar
                            </button>
                        </div>
                        <div class="card-body collapse" id="filterCollapse">
                            <form id="filterForm" class="row g-3">
                                <div class="col-md-3">
                                    <label for="date_from" class="form-label">Fecha desde</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from">
                                </div>
                                <div class="col-md-3">
                                    <label for="date_to" class="form-label">Fecha hasta</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to">
                                </div>
                                <div class="col-md-3">
                                    <label for="customer_id" class="form-label">Cliente</label>
                                    <select class="form-select" id="customer_id" name="customer_id">
                                        <option value="">Seleciione un cliente</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->identification_number }}</option>
                                    @endforeach
                                        
                                       
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="state_type_id" class="form-label">Estado</label>
                                    <select class="form-select" id="state_type_id" name="state_type_id">
                                        <option value="">Todos</option>
                                        <option value="1">Registrado</option>
                                        <option value="2">Enviado</option>
                                        <option value="3">Aceptado</option>
                                        <option value="4">Observado</option>
                                        <option value="5">Rechazado</option>
                                        <option value="6">Anulado</option>
                                        <option value="7">Por Anular</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="button" id="applyFilters" class="btn btn-primary">Aplicar filtros</button>
                                    <button type="button" id="resetFilters" class="btn btn-secondary">Limpiar filtros</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Listado de Pedidos</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group float-end">
                                        <a href="{{url('admin/sales/create')}}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Nueva Venta
                                        </a>
                                        <button type="button" id="exportExcel" class="btn btn-success">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </button>
                                        <button type="button" id="exportPdf" class="btn btn-danger">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tb_purchases">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>No Factura</th>
                                            <th>Estado</th>
                                            <th>Pago</th>
                                            <th>Medio</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Descuento</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Se llenará con AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="alert alert-info">
                                        <strong>Total ventas: </strong><span id="totalSales">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>               
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@section('script')
<script>
    let salesTable;
    let customers = [];
    
    
    
    // Función para cargar las ventas con filtros
    function loadSales(filters = {}) {
        if (salesTable) {
            salesTable.destroy();
        }
        
        $.ajax({
            url: '{{route("admin.sales.fetch")}}',
            method: 'GET',
            dataType: 'json',
            data: filters,
            success: function(data) {
                var tableBody = $('#tb_purchases tbody');
                tableBody.empty();
                
                let totalAmount = 0;

                $.each(data, function(index, sale) {
                    // Format date
                    var issueDate = new Date(sale.date_of_issue).toLocaleDateString();
                    
                    // Format invoice number
                    var invoiceNumber = sale.series && sale.number ? 
                        `${sale.series}-${sale.number}` : 
                        (sale.invoice_no ? sale.invoice_no : 'N/A');
                    
                    // Format currency
                    var formatter = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 2
                    });
                    
                    // Add to total
                    totalAmount += parseFloat(sale.total_sale);
                    
                    // Get state badge class
                    let stateBadgeClass = '';
                    switch(parseInt(sale.state_type_id)) {
                        case 1: stateBadgeClass = 'bg-secondary'; break; // Registrado
                        case 2: stateBadgeClass = 'bg-info'; break; // Enviado
                        case 3: stateBadgeClass = 'bg-success'; break; // Aceptado
                        case 4: stateBadgeClass = 'bg-warning'; break; // Observado
                        case 5: stateBadgeClass = 'bg-danger'; break; // Rechazado
                        case 6: stateBadgeClass = 'bg-dark'; break; // Anulado
                        case 7: stateBadgeClass = 'bg-light text-dark'; break; // Por Anular
                        default: stateBadgeClass = 'bg-secondary';
                    }
                    
                    var row = `<tr>
                                <td>${sale.id}</td>
                                <td>${issueDate}</td>
                                <td>${sale.customers ? sale.customers.name : 'N/A'}</td>
                                <td>${invoiceNumber}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge ${stateBadgeClass} me-2">
                                            ${sale.state_types ? sale.state_types.description : 'N/A'}
                                        </span>
                                        <select class="form-select form-select-sm state-select" data-sale-id="${sale.id}" 
                                        data-current-state="${sale.state_type_id}">
                                            <option value="1" ${sale.state_type_id == 1 ? 'selected' : ''}>Registrado</option>
                                            <option value="2" ${sale.state_type_id == 2 ? 'selected' : ''}>Enviado</option>
                                            <option value="3" ${sale.state_type_id == 3 ? 'selected' : ''}>Aceptado</option>
                                            <option value="4" ${sale.state_type_id == 4 ? 'selected' : ''}>Observado</option>
                                            <option value="5" ${sale.state_type_id == 5 ? 'selected' : ''}>Rechazado</option>
                                            <option value="6" ${sale.state_type_id == 6 ? 'selected' : ''}>Anulado</option>
                                            <option value="7" ${sale.state_type_id == 7 ? 'selected' : ''}>Por Anular</option>
                                        </select>
                                    </div>
                                </td>
                                <td>${sale.payment_form ? sale.payment_form.payment_type : 'N/A'}</td>
                                <td>${sale.payment_method ? sale.payment_method.name : 'N/A'}</td>
                                <td>${formatter.format(sale.total_subtotal)}</td>
                                <td>${formatter.format(sale.total_tax)}</td>
                                <td>${formatter.format(sale.total_discount)}</td>
                                <td>${formatter.format(sale.total_sale)}</td>                                  
                                <td>
                                    <div class="btn-group">
                                       
                                        <button class="btn btn-info btn-sm details-sale" data-id="${sale.id}" title="Ver detalles">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="btn btn-success btn-sm print-pdf" data-sale-id="${sale.id}" title="Imprimir">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="${sale.id}" title="Eliminar">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
                    tableBody.append(row);
                });
                
                // Update total
                $('#totalSales').text(new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                }).format(totalAmount));
                
                // Initialize DataTable
                salesTable = $('#tb_purchases').DataTable({
                    responsive: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'pdf', 'print'
                    ]
                });
                
                // Attach event handlers
                $('.details-sale').on('click', handleDetailsSale);
                $('.state-select').on('change', handleStateChange);
                $('.delete-btn').on('click', handleDelete);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar las ventas'
                });
            }
        });
    }
    
    // Inicializar la página
    $(document).ready(function() {
       // loadCustomers();
        loadSales();
        
        // Event listeners para filtros
        $('#applyFilters').on('click', function() {
            const filters = {
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val(),
                customer_id: $('#customer_id').val(),
                state_type_id: $('#state_type_id').val()
            };
            loadSales(filters);
        });
        
        $('#resetFilters').on('click', function() {
            $('#filterForm')[0].reset();
            loadSales();
        });
        
        // Export buttons
        $('#exportExcel').on('click', function() {
            window.location.href = "{{ route('admin.sales.export.excel') }}";
        });
        
        $('#exportPdf').on('click', function() {
            window.location.href = "{{ route('admin.sales.export.pdf') }}";
        });
    });
    
    // Función para manejar el clic en el botón de detalles
    function handleDetailsSale() {
        var saleId = $(this).data('id');
        window.location.href = "{{ url('admin/sales') }}/" + saleId;
    }
    
    // Manejar cambio de estado
    function handleStateChange() {
        var saleId = $(this).data('sale-id');
        var newStateId = $(this).val();
        var previousStateId = $(this).data('current-state');
        
        if (confirm('¿Está seguro de cambiar el estado de esta venta?')) {
            $.ajax({
                url: "{{ route('admin.sales.update_state') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    sale_id: saleId,
                    state_id: newStateId
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Estado actualizado correctamente',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Actualizar el atributo data-current-state
                        $('.state-select[data-sale-id="' + saleId + '"]').data('current-state', newStateId);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Error al actualizar el estado'
                        });
                        // Revertir la selección al estado anterior
                        $('.state-select[data-sale-id="' + saleId + '"]').val(previousStateId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el estado:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar el estado'
                    });
                    // Revertir la selección al estado anterior
                    $('.state-select[data-sale-id="' + saleId + '"]').val(previousStateId);
                }
            });
        } else {
            // Si el usuario cancela, revertir la selección al estado anterior
            $(this).val(previousStateId);
        }
    };
    
    // Manejar impresión de PDF
    $(document).on('click', '.print-pdf', function() {
        var saleId = $(this).data('sale-id');
        
        if (!saleId) {
            console.error('ID de la venta no encontrado');
            alert('Error: No se pudo identificar la venta');
            return;
        }
        
        // Usar la ruta correcta para generar el PDF
        var url = "{{ route('admin.sales.pdf', ['id' => ':id']) }}".replace(':id', saleId);
        console.log('Abriendo URL:', url);
        window.open(url, '_blank');
    });
    
    // Manejar eliminación de venta
    function handleDelete() {
        var saleId = $(this).data('id');
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.sales.destroy', ['id' => ':id']) }}".replace(':id', saleId),
                    method: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'La venta ha sido eliminada correctamente',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Recargar la tabla
                            loadSales();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se pudo eliminar la venta'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al eliminar la venta:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar la venta'
                        });
                    }
                });
            }
        });
    }
    
    // Función para editar venta
    
    // Inicializar tooltips para los botones de acción
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Inicializar el colapso de filtros
        $('#filterCollapse').on('shown.bs.collapse', function () {
            $('#date_from').focus();
        });
    });
</script>

@endsection
  
      
