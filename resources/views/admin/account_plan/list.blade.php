@extends('layouts.app')

@section('style')
<style>
    .card {
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
    }
    .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #e9ecef;
        padding: 1.25rem;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .table-responsive {
        margin: 0;
        padding: 1rem;
    }
    .table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table thead.table-dark {
        background-color: #f8f9fa !important;
    }
    .table thead.table-dark th {
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
        white-space: nowrap;
    }
    .table tbody td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
        color: #495057;
        font-size: 0.875rem;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn-group .btn {
        margin: 0 0.25rem;
        border-radius: 0.25rem;
    }
    .filter-section {
        background-color: #ffffff;
        padding: 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 1.25rem;
        border: 1px solid #e9ecef;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }
    .form-select, .form-control {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    .search-box {
        position: relative;
    }
    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    .search-box input {
        padding-left: 2.5rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.25rem;
    }
    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #fff;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }
</style>
@endsection

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Gestión de Cuentas</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cuentas</li>
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
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0"><i class="fas fa-boxes me-2"></i>Control de Cuentas PUC</h4>
                                </div>
                                <div class="col-md-6 text-end export-buttons">
                                    <button type="button" class="btn btn-success" id="exportExcel">
                                        <i class="fas fa-file-excel me-1"></i> Exportar Excel
                                    </button>
                                    <button type="button" class="btn btn-danger" id="exportPdf">
                                        <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                                    </button>
                                    <a href="{{url('admin/account_plan/add')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Agregar</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="filter-section">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="accountTypeFilter" class="form-label">
                                                <i class="fas fa-list me-1"></i>Tipo de Cuenta
                                            </label>
                                            <select class="form-select" id="accountTypeFilter">
                                                <option value="">Todos los tipos</option>
                                                <option value="Assets">Activo</option>
                                                <option value="Liabilities">Pasivo</option>
                                                <option value="Equity">Patrimonio</option>
                                                <option value="Income">Ingreso</option>
                                                <option value="Expense">Gasto</option>
                                                <option value="Cost">Costo</option>
                                                <option value="Order">Orden</option>
                                                <option value="Control">Control</option>
                                            </select>
                                        </div>
                                    </div>
                                  
                                  
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="searchInput" class="form-label">
                                                <i class="fas fa-search me-1"></i>Buscar
                                            </label>
                                            <div class="search-box">
                                                <i class="fas fa-search"></i>
                                                <input type="text" class="form-control" id="searchInput" 
                                                       placeholder="Buscar por código o nombre...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="tb_inventory">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Código</th>
                                            <th>Cuenta</th>
                                            <th>Nombre Completo</th>
                                            <th>Cuenta Padre</th>
                                            <th>Nivel</th>
                                            <th>Naturaleza</th>
                                            <th>Tipo</th>
                                            <th>Movimiento</th>
                                            {{-- <th>Ajuste</th>
                                            <th>Tercero</th>
                                            <th>Centro Costo</th>
                                            <th>Base</th>
                                            <th>Retención</th>
                                            <th>Tarifa</th>
                                            <th>Exógeno</th>
                                            <th>Cod Exógeno</th>
                                            <th>Depreciación</th>
                                            <th>Amortización</th> --}}
                                            {{-- <th>Estado</th> --}}
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Los datos se cargarán dinámicamente con AJAX -->
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

<!-- Modal para ajustar inventario -->
<div class="modal fade" id="adjustInventoryModal" tabindex="-1" aria-labelledby="adjustInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustInventoryModalLabel">
                    <i class="fas fa-balance-scale me-2"></i>Ajustar Inventario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="adjustInventoryForm">
                    <input type="hidden" id="inventoryId" name="inventoryId">
                    <div class="mb-3">
                        <label for="productName" class="form-label">
                            <i class="fas fa-box me-1"></i>Producto
                        </label>
                        <input type="text" class="form-control" id="productName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="currentStock" class="form-label">
                            <i class="fas fa-cubes me-1"></i>Stock Actual
                        </label>
                        <input type="text" class="form-control" id="currentStock" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="adjustmentType" class="form-label">
                            <i class="fas fa-exchange-alt me-1"></i>Tipo de Ajuste
                        </label>
                        <select class="form-select" id="adjustmentType" name="adjustmentType" required>
                            <option value="add">Agregar Stock</option>
                            <option value="subtract">Restar Stock</option>
                            <option value="set">Establecer Stock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="adjustmentQuantity" class="form-label">
                            <i class="fas fa-sort-numeric-up me-1"></i>Cantidad
                        </label>
                        <input type="number" class="form-control" id="adjustmentQuantity" 
                               name="adjustmentQuantity" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="adjustmentReason" class="form-label">
                            <i class="fas fa-comment-alt me-1"></i>Motivo del Ajuste
                        </label>
                        <textarea class="form-control" id="adjustmentReason" 
                                  name="adjustmentReason" rows="3" required
                                  placeholder="Ingrese el motivo del ajuste..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="saveAdjustment">
                    <i class="fas fa-save me-1"></i>Guardar Ajuste
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" style="display: none;">
    <div class="spinner-border text-primary loading-spinner" role="status">
        <span class="visually-hidden">Cargando...</span>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        let table = $('#tb_inventory').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('admin.account_plan.fetch') }}",
                data: function(d) {
                    d.account_type = $('#accountTypeFilter').val();
                    d.search = $('#searchInput').val();
                }
            },
            columns: [
                {data: 'id', width: '5%'},
                {data: 'code', width: '8%'},
                {data: 'name', width: '15%'},
                {data: 'full_name', width: '20%'},
                {data: 'parent.name', width: '15%', defaultContent: '-'},
                {data: 'level', width: '5%'},
                {data: 'nature', width: '8%'},
                {data: 'account_type', width: '8%'},
                {data: 'movement', width: '8%'},
                {
                    data: null,
                    width: '8%',
                    className: 'text-center',
                    render: function(data) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info edit-btn" title="Editar" data-id="${data.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" title="Eliminar" data-id="${data.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            order: [[1, 'asc']],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            pageLength: 25,
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex"f>>t<"d-flex justify-content-between align-items-center mt-3"<"text-muted"i><"d-flex"p>>',
            initComplete: function() {
                $('.dataTables_filter').hide();
            }
        });

        // Manejar filtro por tipo de cuenta
        $('#accountTypeFilter').change(function() {
            table.ajax.reload();
        });
        
        // Manejar búsqueda
        $('#searchInput').on('keyup', function() {
            table.ajax.reload();
        });
        
        // Exportar a Excel
        $('#exportExcel').click(function() {
            window.location.href = "{{ route('admin.inventory.export.excel') }}";
        });
        
        // Exportar a PDF
        $('#exportPdf').click(function() {
            window.location.href = "{{ route('admin.inventory.export.pdf') }}";
        });
        
        // Abrir modal de ajuste
        $(document).on('click', '.adjust-btn', function() {
            const inventoryId = $(this).data('id');
            const productName = $(this).data('product');
            const currentStock = $(this).data('stock');
            
            $('#inventoryId').val(inventoryId);
            $('#productName').val(productName);
            $('#currentStock').val(currentStock);
            $('#adjustmentQuantity').val('');
            $('#adjustmentReason').val('');
            
            $('#adjustInventoryModal').modal('show');
        });
        
        // Guardar ajuste de inventario
        $('#saveAdjustment').click(function() {
            if (!$('#adjustInventoryForm')[0].checkValidity()) {
                $('#adjustInventoryForm')[0].reportValidity();
                return;
            }
            
            const inventoryId = $('#inventoryId').val();
            const adjustmentType = $('#adjustmentType').val();
            const adjustmentQuantity = $('#adjustmentQuantity').val();
            const adjustmentReason = $('#adjustmentReason').val();
            
            $.ajax({
                url: "{{ route('admin.inventory.adjust') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    inventory_id: inventoryId,
                    adjustment_type: adjustmentType,
                    quantity: adjustmentQuantity,
                    reason: adjustmentReason
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Inventario ajustado correctamente',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#adjustInventoryModal').modal('hide');
                        loadInventoryData();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Error al ajustar el inventario'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al ajustar el inventario:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al ajustar el inventario'
                    });
                }
            });
        });
    });
    
    // Función para cargar datos de inventario
    function loadInventoryData() {
        console.log('Iniciando carga de inventario...'); // Debug log
        $.ajax({
            url: "{{ route('admin.account_plan.fetch') }}",
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                console.log('Enviando petición...'); // Debug log
                $('#tb_inventory tbody').html('<tr><td colspan="11" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>');
            },
            success: function(data) {
                console.log('Respuesta recibida:', data); // Debug log
                
                if (!data || data.length === 0) {
                    console.log('No hay datos de inventario disponibles'); // Debug log
                    $('#tb_inventory tbody').html('<tr><td colspan="11" class="text-center">No hay datos de inventario disponibles</td></tr>');
                    return;
                }

                renderInventoryTable(data);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
                console.error('Estado:', status);
                console.error('Respuesta:', xhr.responseText);
                $('#tb_inventory tbody').html('<tr><td colspan="11" class="text-center text-danger"><i class="fas fa-exclamation-circle"></i> Error al cargar los datos: ' + error + '</td></tr>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar los datos del inventario: ' + error
                });
            }
        });
    }
    
    // Función para renderizar la tabla de inventario
    function renderInventoryTable(data) {
        console.log('Iniciando renderizado de tabla...'); // Debug log
        
        if ($.fn.DataTable.isDataTable('#tb_inventory')) {
            console.log('Destruyendo DataTable existente...'); // Debug log
            $('#tb_inventory').DataTable().destroy();
        }
        
        var tableBody = $('#tb_inventory tbody');
        tableBody.empty();
        
        console.log('Procesando ' + data.length + ' registros...'); // Debug log
        
        $.each(data, function(index, accounts) {
            console.log('Procesando registro ' + (index + 1) + ':', accounts); // Debug log
            
       
            
            var row = `<tr>
                <td>${accounts.id}</td>
                <td>${accounts.code || 'N/A'}</td>
               
                <td>${accounts.name}</td>
                <td>${accounts.full_name || 'N/A'}</td>
                <td>${accounts.parent_account ? accounts.parent_account.name : 'N/A'}</td>
                <td>${accounts.level || 'N/A'}</td>
                <td>${accounts.nature || 'N/A'}</td>

                <td>${accounts.account_type || 'N/A'}</td>
                <td>${accounts.movement || 'N/A'}</td>
                <td>${accounts.adjustment || 'N/A'}</td>
                <td>${accounts.third_parties || 'N/A'}</td>
                <td>${accounts.cost_center || 'N/A'}</td>
                <td>${accounts.taxable_base || 'N/A'}</td>

              
                <td>
                   
                    <button class="btn btn-info btn-sm history-btn" data-id="${accounts.id}">
                        <i class="fas fa-history"></i> Historial
                    </button>
                </td>
            </tr>`;
            
            tableBody.append(row);
        });
        
        console.log('Inicializando DataTable...'); // Debug log
        
        // Inicializar DataTable
        $('#tb_inventory').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "responsive": true,
            "scrollX": true,
            "order": [[0, 'desc']],
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
                }
            ],
            "initComplete": function() {
                console.log('DataTable inicializado correctamente'); // Debug log
                this.api().columns.adjust();
            }
        });
    }
    
    // Función para cargar opciones de filtro
    function loadFilterOptions() {
        // Cargar bodegas para el filtro
        $.ajax({
            url: "{{ route('admin.warehouses.fetch') }}",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var warehouseFilter = $('#warehouseFilter');
                $.each(data, function(index, warehouse) {
                    warehouseFilter.append(`<option value="${warehouse.id}">${warehouse.warehouse_name}</option>`);
                });
            }
        });
        
        // Cargar categorías para el filtro
        $.ajax({
            url: "{{ route('admin.categories.fetch') }}",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var categoryFilter = $('#categoryFilter');
                $.each(data, function(index, category) {
                    categoryFilter.append(`<option value="${category.id}">${category.category_name}</option>`);
                });
            }
        });
    }
    
    // Función para aplicar filtros
    function applyFilters() {
        const warehouseId = $('#warehouseFilter').val();
        const categoryId = $('#categoryFilter').val();
        const stockFilter = $('#stockFilter').val();
        const searchTerm = $('#searchInput').val().toLowerCase();
        
        // Get the selected warehouse and category names for better matching
        const warehouseName = warehouseId ? $('#warehouseFilter option:selected').text().trim() : '';
        const categoryName = categoryId ? $('#categoryFilter option:selected').text().trim() : '';
        
        console.log('Filtering by warehouse:', warehouseName, 'ID:', warehouseId);
        console.log('Filtering by category:', categoryName, 'ID:', categoryId);
        
        $('#tb_inventory tbody tr').each(function() {
            const row = $(this);
            // Match by warehouse name instead of ID
            const warehouseMatch = !warehouseId || row.find('td:eq(4)').text().trim() === warehouseName;
            // Match by category name instead of ID
            const categoryMatch = !categoryId || row.find('td:eq(3)').text().trim() === categoryName;
            
            const searchMatch = !searchTerm || 
                row.find('td:eq(1)').text().toLowerCase().includes(searchTerm) || 
                row.find('td:eq(2)').text().toLowerCase().includes(searchTerm);
            
            let stockMatch = true;
            if (stockFilter) {
                const stockStatus = row.find('td:eq(9) span').text();
                if (stockFilter === 'low' && stockStatus !== 'Stock Bajo') stockMatch = false;
                if (stockFilter === 'out' && stockStatus !== 'Sin Stock') stockMatch = false;
                if (stockFilter === 'available' && stockStatus !== 'Disponible') stockMatch = false;
            }
            
            if (warehouseMatch && categoryMatch && searchMatch && stockMatch) {
                row.show();
            } else {
                row.hide();
            }
        });
    }
    
    // Función para formatear moneda
    function formatCurrency(value) {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        }).format(value);
    }
    
    // Manejar historial de inventario
    $(document).on('click', '.history-btn', function() {
        const inventoryId = $(this).data('id');
        
        $.ajax({
            url: "{{ route('admin.inventory.history', ['id' => ':id']) }}".replace(':id', inventoryId),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Crear modal dinámicamente
                let modalContent = `
                <div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Historial de Movimientos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Cantidad</th>
                                            <th>Stock Anterior</th>
                                            <th>Stock Nuevo</th>
                                            <th>Motivo</th>
                                            <th>Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                
                $.each(data, function(index, history) {
                    modalContent += `
                        <tr>
                            <td>${history.created_at}</td>
                            <td>${history.movement_type}</td>
                            <td>${history.quantity}</td>
                            <td>${history.previous_stock}</td>
                            <td>${history.new_stock}</td>
                            <td>${history.reason}</td>
                            <td>${history.user ? history.user.name : 'N/A'}</td>
                        </tr>`;
                });
                
                modalContent += `
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                
                // Eliminar modal anterior si existe
                $('#historyModal').remove();
                
                // Agregar nuevo modal al DOM
                $('body').append(modalContent);
                
                // Mostrar modal
                $('#historyModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener el historial:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar el historial de movimientos'
                });
            }
        });
    });
</script>
@endsection
