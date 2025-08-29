@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Factura de Compras</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Factura de Compras
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content-body">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="filter-form" class="row g-3">
                                <div class="col-md-2">
                                    <label for="start_date" class="form-label">Fecha Inicio</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="col-md-2">
                                    <label for="end_date" class="form-label">Fecha Fin</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                                <div class="col-md-3">
                                    <label for="supplier_id" class="form-label">Proveedor</label>
                                    <select class="form-select" id="supplier_id" name="supplier_id">
                                        <option value="">Todos los proveedores</option>
                                        <!-- Los proveedores se cargarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="invoice_no" class="form-label">No. Factura</label>
                                    <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Número de factura">
                                </div>
                                <div class="col-md-2">
                                    <label for="state_type_id" class="form-label">Estado</label>
                                    <select class="form-select" id="state_type_id" name="state_type_id">
                                        <option value="">Todos los estados</option>
                                        <option value="1">Registrado</option>
                                        <option value="2">Enviado</option>
                                        <option value="3">Aceptado</option>
                                        <option value="4">Observado</option>
                                        <option value="5">Rechazado</option>
                                        <option value="6">Anulado</option>
                                        <option value="7">Por Anular</option>
                                    </select>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <div class="btn-group w-100">
                                        <button type="button" id="apply-filters" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button type="button" id="reset-filters" class="btn btn-secondary">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-shopping-cart me-2"></i>Listado de Compras
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{url('admin/purchase/create')}}" class="btn btn-primary float-end">
                                        <i class="fas fa-plus-circle me-1"></i> Nueva Compra
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tb_purchases">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
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
                                        <!-- Data will be loaded dynamically -->
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

@endsection
@section('script')
<script>
    $(document).ready(function() {
        // Set default date range (last 30 days)
        var today = new Date();
        var thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30);
        
        $('#end_date').val(today.toISOString().split('T')[0]);
        $('#start_date').val(thirtyDaysAgo.toISOString().split('T')[0]);
        
        // Load suppliers for filter dropdown
        loadSuppliers();
        
        // Initial data load
        loadPurchaseData();
        
        // Event handlers
        $('#apply-filters').click(function() {
            loadPurchaseData();
        });
        
        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();
            // Reset to default date range
            $('#end_date').val(today.toISOString().split('T')[0]);
            $('#start_date').val(thirtyDaysAgo.toISOString().split('T')[0]);
            loadPurchaseData();
        });
        
        $(document).on('change', '.state-select', handleStateChange);
        $(document).on('click', '.print-pdf', handlePrintPDF);
        $(document).on('click', '.details-purchase', handleDetailsPurchase);
        $(document).on('click', '.delete-btn', handleDeletePurchase);
        
        // Allow pressing Enter to apply filters
        $('#filter-form').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                loadPurchaseData();
            }
        });
    });
    
    // Function to load suppliers for the filter dropdown
    function loadSuppliers() {
        $.ajax({
            url: '{{ url("admin/person/data") }}',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var supplierSelect = $('#supplier_id');
                
                // Filter only suppliers (type_third_id = 2)
                var suppliers = data.filter(function(contact) {
                    return contact.type_third_id === 2;
                });
                
                $.each(suppliers, function(index, supplier) {
                    supplierSelect.append(`<option value="${supplier.id}">${supplier.company_name || supplier.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar proveedores:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los proveedores'
                });
            }
        });
    }
    
    // Function to load purchase data with filters
// Modificar la función loadPurchaseData para manejar la nueva estructura
function loadPurchaseData() {
    // Mostrar loading
    $('#tb_purchases tbody').html('<tr><td colspan="12" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>Cargando datos...</td></tr>');
    
    $.ajax({
        url: '{{ route("admin.purchase.fetch") }}',
        method: 'GET',
        data: {
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            supplier_id: $('#supplier_id').val(),
            invoice_no: $('#invoice_no').val(),
            state_type_id: $('#state_type_id').val()
        },
        success: function(response) {
            renderPurchaseTable(response.data || response);
        },
        error: function(xhr) {
            handleAjaxError(xhr);
        }
    });
}

function renderPurchaseTable(data) {
    var tableBody = $('#tb_purchases tbody');
    tableBody.empty();

    if (data.length === 0) {
        tableBody.html('<tr><td colspan="12" class="text-center">No se encontraron compras con los filtros seleccionados</td></tr>');
        return;
    }

    $.each(data, function(index, purchase) {
        var supplierName = purchase.suppliers ? 
                         (purchase.suppliers.company_name || purchase.suppliers.name) : 
                         'N/A';
        
        var paymentType = purchase.payment_types ? 
                         purchase.payment_types.payment_type : 
                         'N/A';
                         
        var paymentMethod = purchase.payment_method ? 
                          purchase.payment_method.name : 
                          'N/A';

        var row = `<tr>
            <td>${purchase.id}</td>
            <td>${formatDate(purchase.date_of_issue)}</td>
            <td>${supplierName}</td>
            <td>${purchase.invoice_no}</td>
            <td>
                <select class="form-select form-select-sm state-select ${getStatusClass(purchase.state_type.id)}" 
                        data-purchase-id="${purchase.id}" 
                        data-current-state="${purchase.state_type.id}">
                    <option value="1" ${purchase.state_type.id == 1 ? 'selected' : ''}>Registrado</option>
                    <option value="2" ${purchase.state_type.id == 2 ? 'selected' : ''}>Enviado</option>
                    <option value="3" ${purchase.state_type.id == 3 ? 'selected' : ''}>Aceptado</option>
                    <option value="4" ${purchase.state_type.id == 4 ? 'selected' : ''}>Observado</option>
                    <option value="5" ${purchase.state_type.id == 5 ? 'selected' : ''}>Rechazado</option>
                    <option value="6" ${purchase.state_type.id == 6 ? 'selected' : ''}>Anulado</option>
                    <option value="7" ${purchase.state_type.id == 7 ? 'selected' : ''}>Por Anular</option>
                </select>
            </td>
            <td>${paymentType}</td>
            <td>${paymentMethod}</td>
            <td class="text-end">${formatCurrency(purchase.total_subtotal)}</td>
            <td class="text-end">${formatCurrency(purchase.total_tax)}</td>
            <td class="text-end">${formatCurrency(purchase.total_discount || 0)}</td>
            <td class="text-end fw-bold">${formatCurrency(purchase.total_purchase)}</td>
            <td>
                <div class="btn-group" role="group">
                    <button class="btn btn-info btn-sm details-purchase" data-id="${purchase.id}" title="Ver detalles">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button class="btn btn-success btn-sm print-pdf" data-purchase-id="${purchase.id}" title="Imprimir">
                        <i class="fa-solid fa-print"></i>
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${purchase.id}" title="Eliminar">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>`;
        
        tableBody.append(row);
    });

    initializeDataTable();
}

function handleAjaxError(xhr) {
    console.error('Error:', xhr.responseText);
    $('#tb_purchases tbody').html('<tr><td colspan="12" class="text-center text-danger">Error al cargar los datos</td></tr>');
    
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: xhr.responseJSON?.message || 'Error al cargar los datos'
    });
}
    
    // Initialize DataTable with proper configuration
    function initializeDataTable() {
        if ($.fn.DataTable.isDataTable('#tb_purchases')) {
            $('#tb_purchases').DataTable().destroy();
        }
        
        $('#tb_purchases').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 5, 6, 7, 8, 9, 10]
                    },
                    title: 'Reporte de Compras',
                    filename: 'Compras_' + new Date().toISOString().slice(0, 10)
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 5, 6, 7, 8, 9, 10]
                    },
                    title: 'Reporte de Compras',
                    filename: 'Compras_' + new Date().toISOString().slice(0, 10)
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 5, 6, 7, 8, 9, 10]
                    },
                    title: 'Reporte de Compras'
                }
            ]
        });
    }
    
    // Handle state change
    function handleStateChange() {
        var purchaseId = $(this).data('purchase-id');
        var newStateId = $(this).val();
        var previousStateId = $(this).data('current-state');
        
        Swal.fire({
            title: '¿Cambiar estado?',
            text: 'Esta acción afectará tu inventario lógico y físico. ¿Desea continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                updatePurchaseState(purchaseId, newStateId, previousStateId, this);
            } else {
                // Revert selection if canceled
                $(this).val(previousStateId);
            }
        });
    }
    
    // Update purchase state via AJAX
    function updatePurchaseState(purchaseId, newStateId, previousStateId, element) {
        $.ajax({
            url: "{{ route('admin.purchase.update_state') }}",
            method: 'POST',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                purchase_id: purchaseId,
                state_id: newStateId
            },
            beforeSend: function() {
                // Disable the select while processing
                $(element).prop('disabled', true);
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
                    // Update data attribute and select class
                    $(element).data('current-state', newStateId);
                    $(element).removeClass().addClass('form-select form-select-sm state-select ' + getStatusClass(newStateId));
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Error al actualizar el estado'
                    });
                    // Revert selection
                    $(element).val(previousStateId);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar el estado:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar el estado'
                });
                // Revert selection
                $(element).val(previousStateId);
            },
            complete: function() {
                // Re-enable the select
                $(element).prop('disabled', false);
            }
        });
    }
    
    // Handle print PDF
    function handlePrintPDF() {
        var purchaseId = $(this).data('purchase-id');
        
        if (!purchaseId) {
            console.error('ID de la compra no encontrado');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo identificar la compra'
            });
            return;
        }
        
        var url = "{{ route('admin.purchase.pdf', ['id' => ':id']) }}".replace(':id', purchaseId);
        window.open(url, '_blank');
    }
    
    // Handle details view
    function handleDetailsPurchase() {
        var purchaseId = $(this).data('id');
        window.location.href = "{{ url('admin/purchase') }}/" + purchaseId;
    }
    
    // Handle delete purchase
    function handleDeletePurchase() {
        var purchaseId = $(this).data('id');
        
        Swal.fire({
            title: '¿Eliminar compra?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/purchase/delete') }}/" + purchaseId,
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
                                text: 'La compra ha sido eliminada',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadPurchaseData();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Error al eliminar la compra'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al eliminar:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar la compra'
                        });
                    }
                });
            }
        });
    }
    
    // Helper function to format currency
    function formatCurrency(value) {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 2
        }).format(value);
    }
    
    // Helper function to format date
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('es-CO');
    }
    
    // Helper function to get status class
    function getStatusClass(stateId) {
        switch (parseInt(stateId)) {
            case 1: return 'bg-secondary text-white'; // Registrado
            case 2: return 'bg-info text-white'; // Enviado
            case 3: return 'bg-success text-white'; // Aceptado
            case 4: return 'bg-warning text-dark'; // Observado
            case 5: return 'bg-danger text-white'; // Rechazado
            case 6: return 'bg-dark text-white'; // Anulado
            case 7: return 'bg-danger text-white'; // Por Anular
            default: return '';
        }
    }
</script>
@endsection
  
      
