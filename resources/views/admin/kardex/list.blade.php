@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Movimientos</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Movimiento Items
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
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Listado de Movimientos</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group float-end">
                                        <button type="button" class="btn btn-success" id="exportExcel">
                                            <i class="fas fa-file-excel me-1"></i> Exportar Excel
                                        </button>
                                        <button type="button" class="btn btn-danger" id="exportPdf">
                                            <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="warehouseFilter">Filtrar por Bodega:</label>
                                        <select class="form-select" id="warehouseFilter">
                                            <option value="">Todas las bodegas</option>
                                        </select>
                                    </div>
                                </div>
                             
                             
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="searchInput">Buscar:</label>
                                        <input type="text" class="form-control" id="searchInput" placeholder="Buscar producto...">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tb_inventory">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            
                                            <th>Bodega</th>
                                            <th>Tipo</th>
                                            <th>Referencia</th>
                                            <th>Cantidad </th>
                                            <th>Stock Anterior</th>
                                            <th>Stock Nuevo</th>
                                          
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
                <h5 class="modal-title" id="adjustInventoryModalLabel">Ajustar Inventario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="adjustInventoryForm">
                    <input type="hidden" id="inventoryId" name="inventoryId">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Producto:</label>
                        <input type="text" class="form-control" id="productName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="currentStock" class="form-label">Stock Actual:</label>
                        <input type="text" class="form-control" id="currentStock" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="adjustmentType" class="form-label">Tipo de Ajuste:</label>
                        <select class="form-select" id="adjustmentType" name="adjustmentType" required>
                            <option value="add">Agregar</option>
                            <option value="subtract">Restar</option>
                            <option value="set">Establecer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="adjustmentQuantity" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="adjustmentQuantity" name="adjustmentQuantity" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="adjustmentReason" class="form-label">Motivo:</label>
                        <textarea class="form-control" id="adjustmentReason" name="adjustmentReason" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveAdjustment">Guardar Ajuste</button>
            </div>
        </div>
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
        $('#warehouseFilter').change(function() {
            loadInventoryData(); // Recargar datos con filtros
        });
        
        // Manejar búsqueda
        $('#searchInput').on('keyup', function() {
            // Usar debounce para evitar múltiples solicitudes
            clearTimeout($(this).data('timeout'));
            $(this).data('timeout', setTimeout(function() {
                loadInventoryData(); // Recargar datos con filtros
            }, 500));
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
        const warehouseId = $('#warehouseFilter').val();
        const searchTerm = $('#searchInput').val();
        
        // Show loading indicator
        Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo datos del inventario',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: "{{ route('admin.movements.fetch') }}",
            method: 'GET',
            dataType: 'json',
            data: {
                warehouse_id: warehouseId,
                search: searchTerm
            },
            success: function(data) {
                // Close loading indicator
                Swal.close();
                
                // Log the response for debugging
                console.log('API Response:', data);
                console.log('Warehouse ID sent:', warehouseId);
                
                renderInventoryTable(data);
                
                // Apply client-side filtering as a fallback
                if (warehouseId || searchTerm) {
                    setTimeout(function() {
                        const table = $('#tb_inventory').DataTable();
                        
                        // Clear any existing search
                        table.search('').columns().search('').draw();
                        
                        if (searchTerm) {
                            table.search(searchTerm).draw();
                        }
                        
                        if (warehouseId) {
                            // Get the warehouse name from the select option
                            const warehouseName = $('#warehouseFilter option:selected').text();
                            console.log('Filtering by warehouse:', warehouseName);
                            
                            // Filter by warehouse name instead of ID
                            table.column(3).search(warehouseName).draw();
                        }
                    }, 100);
                }
            },
            error: function(xhr, status, error) {
                // Close loading indicator
                Swal.close();
                
                console.error('Error al obtener los datos:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar los datos del inventario'
                });
            }
        });
    }
    
    // Función para renderizar la tabla de inventario
    function renderInventoryTable(data) {
        if ($.fn.DataTable.isDataTable('#tb_inventory')) {
            $('#tb_inventory').DataTable().destroy();
        }
        
        var tableBody = $('#tb_inventory tbody');
        tableBody.empty();
        
        $.each(data, function(index, movement) {
            // Determinar el estado del stock
            let stockStatus = '';
            let stockClass = '';
            
            if (movement.stock <= 0) {
                stockStatus = 'Sin Stock';
                stockClass = 'bg-danger text-white';
            } else if (movement.stock <= movement.item.min_stock) {
                stockStatus = 'Stock Bajo';
                stockClass = 'bg-warning';
            } else {
                stockStatus = 'Disponible';
                stockClass = 'bg-success text-white';
            }
            
            var row = `<tr>
                <td>${movement.id}</td>
                <td>${movement.item.barcode || 'N/A'}</td>
                <td>${movement.item.product_name}</td>              
                <td>${movement.warehouse.warehouse_name}</td>
                <td>${movement.movement_type.name}</td>
                <td>${movement.reference_type}</td>
                <td>${movement.quantity}</td>
                <td>${movement.previous_stock}</td>
                <td>${movement.new_stock}</td>
               
                <td>
                    
                    <button class="btn btn-info btn-sm history-btn" data-id="${movement.id}">
                        <i class="fas fa-history"></i> Historial
                    </button>
                </td>
            </tr>`;
            
            tableBody.append(row);
        });
        
        // Inicializar DataTable
        $('#tb_inventory').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
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
        
    
    }
    
    // Función para aplicar filtros
    function applyFilters() {
        const warehouseId = $('#warehouseFilter').val();
        const searchTerm = $('#searchInput').val().toLowerCase();
        
        // Reinicializar DataTable con los filtros aplicados
        if ($.fn.DataTable.isDataTable('#tb_inventory')) {
            $('#tb_inventory').DataTable().destroy();
        }
        
        // Inicializar DataTable con filtros
        $('#tb_inventory').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            initComplete: function() {
                // Aplicar filtros personalizados después de que DataTable se inicialice
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        // Verificar coincidencia de bodega
                        const warehouseMatch = !warehouseId || data[3].includes(warehouseId);
                        
                        // Verificar coincidencia de búsqueda (código o nombre del producto)
                        const searchMatch = !searchTerm || 
                            data[1].toLowerCase().includes(searchTerm) || 
                            data[2].toLowerCase().includes(searchTerm);
                        
                        return warehouseMatch && searchMatch;
                    }
                );
                
                // Redibujar la tabla para aplicar los filtros
                $('#tb_inventory').DataTable().draw();
                
                // Limpiar los filtros personalizados para futuras búsquedas
                $.fn.dataTable.ext.search.pop();
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