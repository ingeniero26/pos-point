@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">🏢 Gestión de Áreas</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">🏠 Inicio</a></li>
                        <li class="breadcrumb-item active">🏢 Áreas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-building"></i> Áreas de la Empresa
                                </h3>
                                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addAreaModal">
                                    <i class="fas fa-plus"></i> Nueva Área
                                </button>
                                <!-- <button type="button" class="btn btn-info btn-sm ms-2" onclick="debugAreas()">
                                    <i class="fas fa-bug"></i> Debug
                                </button> -->
                                <button type="button" class="btn btn-secondary btn-sm ms-2" onclick="toggleDataTable()">
                                    <i class="fas fa-table"></i> <span id="tableToggleText">Tabla Básica</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                          
                            
                            <div class="table-responsive">
                                <table id="areasTable" class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Área Padre</th>
                                            <th>Responsable</th>
                                            <th>Centro de Costo</th>
                                            <th>Estado</th>
                                            <th>Creado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($areas as $area)
                                        <tr>
                                            <td>{{ $area->id }}</td>
                                            <td>
                                                <strong>{{ $area->name }}</strong>
                                                @if($area->description)
                                                <br><small class="text-muted">{{ Str::limit($area->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($area->parent)
                                                    {{ $area->parent->name }}
                                                @else
                                                    <span class="text-muted">Área Principal</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $area->manager->name ?? 'Sin asignar' }}
                                            </td>
                                            <td>
                                                {{ $area->costCenter->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                @if($area->status)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $area->created_at ? $area->created_at->format('d/m/Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                        onclick="viewArea({{ $area->id }})" 
                                                        title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning" 
                                                        onclick="editArea({{ $area->id }})" 
                                                        title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteArea({{ $area->id }}, '{{ addslashes($area->name) }}')" 
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
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

<!-- Modal para Agregar Área -->
<div class="modal fade" id="addAreaModal" tabindex="-1" aria-labelledby="addAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addAreaModalLabel">
                    <i class="fas fa-plus-circle"></i> Nueva Área
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addAreaForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag text-primary"></i> Nombre del Área *
                                </label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">
                                    <i class="fas fa-sitemap text-info"></i> Área Padre
                                </label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="">Seleccionar área padre (opcional)</option>
                                    @foreach($areas->where('status', true) as $parentArea)
                                        <option value="{{ $parentArea->id }}">{{ $parentArea->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left text-secondary"></i> Descripción
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  placeholder="Descripción del área y sus funciones..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="manager_id" class="form-label">
                                    <i class="fas fa-user-tie text-success"></i> Responsable
                                </label>
                                <select class="form-select" id="manager_id" name="manager_id">
                                    <option value="">Seleccionar responsable (opcional)</option>
                                    <!-- Se llenará dinámicamente -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cost_center_id" class="form-label">
                                    <i class="fas fa-calculator text-warning"></i> Centro de Costo
                                </label>
                                <select class="form-select" id="cost_center_id" name="cost_center_id">
                                    <option value="">Seleccionar centro de costo (opcional)</option>
                                    <!-- Se llenará dinámicamente -->
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">
                            <i class="fas fa-toggle-on text-primary"></i> Estado
                        </label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Área
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Área -->
<div class="modal fade" id="editAreaModal" tabindex="-1" aria-labelledby="editAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editAreaModalLabel">
                    <i class="fas fa-edit"></i> Editar Área
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAreaForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_area_id" name="area_id">
                <div class="modal-body">
                    <!-- Mismo contenido que el modal de agregar, pero con IDs diferentes -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">
                                    <i class="fas fa-tag text-primary"></i> Nombre del Área *
                                </label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_parent_id" class="form-label">
                                    <i class="fas fa-sitemap text-info"></i> Área Padre
                                </label>
                                <select class="form-select" id="edit_parent_id" name="parent_id">
                                    <option value="">Seleccionar área padre (opcional)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">
                            <i class="fas fa-align-left text-secondary"></i> Descripción
                        </label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_manager_id" class="form-label">
                                    <i class="fas fa-user-tie text-success"></i> Responsable
                                </label>
                                <select class="form-select" id="edit_manager_id" name="manager_id">
                                    <option value="">Seleccionar responsable (opcional)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_cost_center_id" class="form-label">
                                    <i class="fas fa-calculator text-warning"></i> Centro de Costo
                                </label>
                                <select class="form-select" id="edit_cost_center_id" name="cost_center_id">
                                    <option value="">Seleccionar centro de costo (opcional)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">
                            <i class="fas fa-toggle-on text-primary"></i> Estado
                        </label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Actualizar Área
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {
    // No inicializar DataTable automáticamente para evitar errores
    // El usuario puede activarlo manualmente con el botón "Activar DataTable"
    console.log('Page loaded. DataTable can be activated manually.');

    // Cargar datos cuando se abra el modal de agregar
    $('#addAreaModal').on('show.bs.modal', function() {
        loadCreateData();
    });

    // Cargar datos para los selects (función de respaldo)
    loadSelectData();

    // Manejar envío del formulario de agregar
    $('#addAreaForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("admin.areas.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    Object.keys(errors).forEach(key => {
                        $(`#${key}`).addClass('is-invalid');
                        $(`#${key}`).siblings('.invalid-feedback').text(errors[key][0]);
                    });
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.message || 'Error al crear el área'
                });
            }
        });
    });

    // Manejar envío del formulario de editar
    $('#editAreaForm').on('submit', function(e) {
        e.preventDefault();
        
        const areaId = $('#edit_area_id').val();
        const formData = new FormData(this);
        
        $.ajax({
            url: `{{ url('admin/areas/update') }}/${areaId}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    Object.keys(errors).forEach(key => {
                        $(`#edit_${key}`).addClass('is-invalid');
                        $(`#edit_${key}`).siblings('.invalid-feedback').text(errors[key][0]);
                    });
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.message || 'Error al actualizar el área'
                });
            }
        });
    });
});

function initializeDataTable() {
    try {
        // Destruir DataTable existente si existe
        if ($.fn.DataTable.isDataTable('#areasTable')) {
            $('#areasTable').DataTable().destroy();
            $('#areasTable').empty();
        }
        
        // Esperar a que el DOM esté completamente cargado
        setTimeout(function() {
            // Verificar que la tabla existe y tiene estructura válida
            if ($('#areasTable').length === 0) {
                console.error('Table #areasTable not found');
                return;
            }
            
            const headerCols = $('#areasTable thead th').length;
            const bodyRows = $('#areasTable tbody tr').length;
            
            console.log('DataTable Debug:', {
                headerColumns: headerCols,
                bodyRows: bodyRows,
                tableExists: $('#areasTable').length > 0
            });
            
            // Solo inicializar si la estructura es válida
            if (headerCols > 0) {
                // Configuración simplificada de DataTable
                $('#areasTable').DataTable({
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay áreas registradas. Haz clic en 'Nueva Área' para crear la primera área.",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                        "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "No se encontraron registros coincidentes",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    responsive: true,
                    order: [[1, 'asc']],
                    columnDefs: [
                        { orderable: false, targets: [7] },
                        { className: "text-center", targets: [0, 5, 7] }
                    ],
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                         '<"row"<"col-sm-12"tr>>' +
                         '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    drawCallback: function() {
                        // Reinicializar tooltips después de cada redibujado
                        $('[title]').tooltip();
                    }
                });
                
                console.log('DataTable initialized successfully');
            } else {
                console.warn('Invalid table structure, skipping DataTable initialization');
            }
        }, 500); // Aumentar el delay para asegurar que el DOM esté listo
        
    } catch (error) {
        console.error('Error initializing DataTable:', error);
        
        // Fallback: hacer la tabla funcional sin DataTables
        $('#areasTable').removeClass('dataTable');
        $('#areasTable').addClass('table-responsive');
        console.log('Fallback: Using basic table functionality');
    }
}

function loadCreateData() {
    $.get('{{ route("admin.areas.create") }}', function(response) {
        if (response.success) {
            // Cargar áreas padre
            $('#parent_id').empty().append('<option value="">Seleccionar área padre (opcional)</option>');
            if (response.parentAreas && Array.isArray(response.parentAreas)) {
                response.parentAreas.forEach(area => {
                    $('#parent_id').append(`<option value="${area.id}">${area.name}</option>`);
                });
            }
            
            // Cargar responsables
            $('#manager_id').empty().append('<option value="">Seleccionar responsable (opcional)</option>');
            if (response.managers && Array.isArray(response.managers)) {
                response.managers.forEach(manager => {
                    $('#manager_id').append(`<option value="${manager.id}">${manager.name}</option>`);
                });
            }
            
            // Cargar centros de costo
            $('#cost_center_id').empty().append('<option value="">Seleccionar centro de costo (opcional)</option>');
            if (response.costCenters && Array.isArray(response.costCenters)) {
                response.costCenters.forEach(center => {
                    $('#cost_center_id').append(`<option value="${center.id}">${center.name}</option>`);
                });
            }
        }
    }).fail(function() {
        console.error('Error al cargar datos para crear área');
    });
}

function loadSelectData() {
    // Esta función se mantiene como respaldo para compatibilidad
    loadCreateData();
}

function viewArea(id) {
    window.location.href = `{{ url('admin/areas/show') }}/${id}`;
}

function editArea(id) {
    // Cargar datos del área
    $.get(`{{ url('admin/areas/edit') }}/${id}`, function(response) {
        if (response.area) {
            // Llenar el formulario con los datos
            $('#edit_area_id').val(response.area.id);
            $('#edit_name').val(response.area.name);
            $('#edit_description').val(response.area.description);
            $('#edit_status').val(response.area.status ? 1 : 0);
            
            // Cargar áreas padre (excluyendo la actual)
            $('#edit_parent_id').empty().append('<option value="">Seleccionar área padre (opcional)</option>');
            if (response.parentAreas && Array.isArray(response.parentAreas)) {
                response.parentAreas.forEach(area => {
                    $('#edit_parent_id').append(`<option value="${area.id}">${area.name}</option>`);
                });
            }
            $('#edit_parent_id').val(response.area.parent_id);
            
            // Cargar responsables
            $('#edit_manager_id').empty().append('<option value="">Seleccionar responsable (opcional)</option>');
            if (response.managers && Array.isArray(response.managers)) {
                response.managers.forEach(manager => {
                    $('#edit_manager_id').append(`<option value="${manager.id}">${manager.name}</option>`);
                });
            }
            $('#edit_manager_id').val(response.area.manager_id);
            
            // Cargar centros de costo
            $('#edit_cost_center_id').empty().append('<option value="">Seleccionar centro de costo (opcional)</option>');
            if (response.costCenters && Array.isArray(response.costCenters)) {
                response.costCenters.forEach(center => {
                    $('#edit_cost_center_id').append(`<option value="${center.id}">${center.name}</option>`);
                });
            }
            $('#edit_cost_center_id').val(response.area.cost_center_id);
            
            $('#editAreaModal').modal('show');
        }
    }).fail(function(xhr) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cargar los datos del área'
        });
    });
}

function deleteArea(id, name) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas eliminar el área "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('admin/areas/delete') }}/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminado!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message || 'Error al eliminar el área'
                    });
                }
            });
        }
    });
}

function debugAreas() {
    $.get('{{ route("admin.areas.debug") }}', function(response) {
        console.log('Debug Areas:', response);
        
        if (response.error) {
            Swal.fire({
                icon: 'error',
                title: 'Error en Debug',
                html: `<strong>Error:</strong> ${response.message}<br><br><pre>${response.trace}</pre>`,
                width: '800px',
                confirmButtonText: 'Cerrar'
            });
            return;
        }
        
        let debugInfo = `
            <strong>Información de Conexión:</strong><br>
            Base de datos: ${response.database_name}<br>
            Tabla 'areas' existe: ${response.table_exists ? 'Sí' : 'No'}<br>
            Consulta directa count: ${response.direct_query_count}<br>
            Consulta modelo count: ${response.model_query_count}<br><br>
            
            <strong>Información de Filtros:</strong><br>
            Company ID del usuario: ${response.user_company_id}<br>
            Total de áreas en BD: ${response.total_areas}<br>
            Áreas con company_id ${response.user_company_id}: ${response.areas_with_company}<br>
            Áreas no eliminadas: ${response.areas_not_deleted}<br>
            Áreas activas: ${response.areas_active}<br><br>
        `;
        
        if (response.areas_data && response.areas_data.length > 0) {
            debugInfo += '<strong>Datos de áreas (modelo):</strong><br>';
            response.areas_data.forEach(area => {
                debugInfo += `
                    ID: ${area.id}, Nombre: ${area.name}, 
                    Company ID: ${area.company_id}, 
                    Is Delete: ${area.is_delete}, 
                    Status: ${area.status}<br>
                `;
            });
        }
        
        if (response.raw_table_data && response.raw_table_data.length > 0) {
            debugInfo += '<br><strong>Datos directos de tabla:</strong><br>';
            response.raw_table_data.forEach(area => {
                debugInfo += `
                    ID: ${area.id}, Nombre: ${area.name}, 
                    Company ID: ${area.company_id}, 
                    Is Delete: ${area.is_delete}, 
                    Status: ${area.status}<br>
                `;
            });
        }
        
        Swal.fire({
            title: 'Debug Completo de Áreas',
            html: debugInfo,
            width: '800px',
            confirmButtonText: 'Cerrar'
        });
    }).fail(function(xhr) {
        console.error('Debug failed:', xhr);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al obtener información de debug: ' + (xhr.responseJSON?.message || xhr.statusText)
        });
    });
}

let isDataTableActive = false;

function toggleDataTable() {
    if (isDataTableActive) {
        // Destruir DataTable y usar tabla básica
        if ($.fn.DataTable.isDataTable('#areasTable')) {
            $('#areasTable').DataTable().destroy();
        }
        $('#areasTable').removeClass('dataTable');
        $('#tableToggleText').text('Activar DataTable');
        isDataTableActive = false;
        console.log('DataTable disabled, using basic table');
    } else {
        // Activar DataTable
        try {
            initializeDataTable();
            $('#tableToggleText').text('Tabla Básica');
            isDataTableActive = true;
            console.log('DataTable enabled');
        } catch (error) {
            console.error('Failed to enable DataTable:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo activar DataTable. Usando tabla básica.'
            });
        }
    }
}
</script>
@endsection