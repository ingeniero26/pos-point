@extends('layouts.app')

@section('style')
<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
        margin-bottom: 1.5rem;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem;
    }
    .table-responsive {
        margin-top: 1rem;
    }
    .btn-group .btn {
        margin: 0 2px;
    }
    .filter-section {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .badge {
        padding: 0.5em 0.75em;
        font-size: 0.875em;
    }
    .stock-status {
        font-weight: 500;
    }
    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .dataTables_wrapper {
        padding: 1rem 0;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .table td {
        vertical-align: middle;
    }
    .search-box {
        position: relative;
    }
    .search-box i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    .search-box input {
        padding-left: 35px;
    }
    .export-buttons .btn {
        margin-left: 0.5rem;
    }
    .stock-warning {
        color: #dc3545;
        font-weight: 500;
    }
    .stock-normal {
        color: #28a745;
        font-weight: 500;
    }
    .stock-low {
        color: #ffc107;
        font-weight: 500;
    }
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }
    .history-table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .loading-spinner {
        width: 3rem;
        height: 3rem;
    }
    .table thead.table-dark {
        background-color: #f8f9fa !important;
        color: #000000;
        border-bottom: 2px solid #dee2e6;
    }
    .table thead.table-dark th {
        border-color: #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 12px 8px;
        background-color: #f8f9fa;
        color: #000000;
    }
</style>
@endsection

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Gestión de Inventario</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inventario</li>
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
                                    <h4 class="mb-0"><i class="fas fa-boxes me-2"></i>Control de Inventario</h4>
                                </div>
                                <div class="col-md-6 text-end export-buttons">
                                    <button type="button" class="btn btn-success" id="exportExcel">
                                        <i class="fas fa-file-excel me-1"></i> Exportar Excel
                                    </button>
                                    <button type="button" class="btn btn-danger" id="exportPdf">
                                        <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="filter-section">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="warehouseFilter" class="form-label">
                                                <i class="fas fa-warehouse me-1"></i>Bodega
                                            </label>
                                            <select class="form-select" id="warehouseFilter">
                                                <option value="">Todas las bodegas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="categoryFilter" class="form-label">
                                                <i class="fas fa-tags me-1"></i>Categoría
                                            </label>
                                            <select class="form-select" id="categoryFilter">
                                                <option value="">Todas las categorías</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="stockFilter" class="form-label">
                                                <i class="fas fa-box me-1"></i>Estado de Stock
                                            </label>
                                            <select class="form-select" id="stockFilter">
                                                <option value="">Todos</option>
                                                <option value="low">Stock Bajo</option>
                                                <option value="out">Sin Stock</option>
                                                <option value="available">Disponible</option>
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
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary w-100" id="applyFilters">
                                            <i class="fas fa-filter me-1"></i>Aplicar Filtros
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="tb_inventory">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Categoría</th>
                                            <th>Bodega</th>
                                            <th>Stock</th>
                                            <th>Unidad</th>
                                            <th>Precio Costo</th>
                                            <th>Precio Venta</th>
                                            <th>Impuesto</th>
                                            <th>Estado</th>
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
        // Cargar datos de inventario
        loadInventoryData();
        
        // Inicializar filtros
        loadFilterOptions();
        
        // Manejar filtros
        $('#warehouseFilter, #categoryFilter, #stockFilter').change(function() {
            applyFilters();
        });
        
        // Manejar búsqueda
        $('#searchInput').on('keyup', function() {
            applyFilters();
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
        
        // Aplicar filtros al hacer clic en el botón
        $('#applyFilters').click(function() {
            applyFilters();
        });
    });
    
    // Función para cargar datos de inventario
    function loadInventoryData() {
        console.log('Iniciando carga de inventario...'); // Debug log
        $.ajax({
            url: "{{ route('admin.inventory.fetch') }}",
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                console.log('Enviando petición...'); // Debug log
                $('#tb_inventory tbody').html('<tr><td colspan="12" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>');
            },
            success: function(data) {
                console.log('Respuesta recibida:', data); // Debug log
                
                if (!data || !data.data || data.data.length === 0) {
                    console.log('No hay datos de inventario disponibles'); // Debug log
                    $('#tb_inventory tbody').html('<tr><td colspan="12" class="text-center">No hay datos de inventario disponibles</td></tr>');
                    return;
                }

                renderInventoryTable(data.data);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
                console.error('Estado:', status);
                console.error('Respuesta:', xhr.responseText);
                $('#tb_inventory tbody').html('<tr><td colspan="12" class="text-center text-danger"><i class="fas fa-exclamation-circle"></i> Error al cargar los datos: ' + error + '</td></tr>');
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
        
        $.each(data, function(index, inventory) {
            console.log('Procesando registro ' + (index + 1) + ':', inventory); // Debug log
            
            // Determinar el estado del stock
            let stockStatus = '';
            let stockClass = '';
            
            if (inventory.stock <= 0) {
                stockStatus = 'Sin Stock';
                stockClass = 'bg-danger text-white';
            } else if (inventory.stock <= inventory.min_quantity) {
                stockStatus = 'Stock Bajo';
                stockClass = 'bg-warning';
            } else {
                stockStatus = 'Disponible';
                stockClass = 'bg-success text-white';
            }
            
            var row = `<tr>
                <td>${inventory.id}</td>
                <td>${inventory.item ? (inventory.item.barcode || 'N/A') : 'N/A'}</td>
                <td>${inventory.item ? inventory.item.product_name : 'N/A'}</td>
                <td>${inventory.item && inventory.item.category ? inventory.item.category.category_name : 'N/A'}</td>
                <td>${inventory.warehouse ? inventory.warehouse.warehouse_name : 'N/A'}</td>
                <td>${typeof inventory.stock !== 'undefined' ? inventory.stock : 'N/A'}</td>
                <td>${inventory.item && inventory.item.measure ? inventory.item.measure.measure_name : 'N/A'}</td>
                <td>${inventory.item && inventory.item.cost_price !== undefined ? formatCurrency(inventory.item.cost_price) : 'N/A'}</td>
                <td>${inventory.item && inventory.item.selling_price !== undefined ? formatCurrency(inventory.item.selling_price) : 'N/A'}</td>
                <td>${inventory.item && inventory.item.tax ? inventory.item.tax.tax_name + ' (' + inventory.item.tax.rate + '%)' : 'N/A'}</td>
                <td><span class="badge ${stockClass}">${stockStatus}</span></td>
                <td>
                    <button class="btn btn-primary btn-sm adjust-btn" 
                        data-id="${inventory.id}" 
                        data-product="${inventory.item ? inventory.item.product_name : 'N/A'}"
                        data-stock="${typeof inventory.stock !== 'undefined' ? inventory.stock : 0}">
                        <i class="fas fa-balance-scale"></i> Ajustar
                    </button>
                    <button class="btn btn-info btn-sm history-btn" data-id="${inventory.id}">
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