@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Gestión de Permisos</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('permissions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Permiso
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="filterModule">Módulo</label>
                    <input type="text" class="form-control" id="filterModule" placeholder="Filtrar por módulo">
                </div>
                <div class="col-md-4">
                    <label for="filterCategory">Categoría</label>
                    <input type="text" class="form-control" id="filterCategory" placeholder="Filtrar por categoría">
                </div>
                <div class="col-md-4">
                    <label for="filterAction">Acción</label>
                    <input type="text" class="form-control" id="filterAction" placeholder="Filtrar por acción">
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Permisos -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Permisos Registrados</h5>
            <div>
                <button id="btnSelectAll" class="btn btn-sm btn-secondary">Seleccionar Todo</button>
                <button id="btnDeleteSelected" class="btn btn-sm btn-danger" style="display:none;">
                    <i class="fas fa-trash"></i> Eliminar Seleccionados
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="permissionsTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAllCheckbox">
                            </th>
                            <th>Módulo</th>
                            <th>Acción</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Sistema</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="permissionsBody">
                        <tr>
                            <td colspan="7" class="text-center text-muted">Cargando permisos...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmación de eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar este permiso?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        max-height: 600px;
        overflow-y: auto;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .status-system {
        background-color: #e7f3ff;
        color: #004085;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let permissionsData = [];
    let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    let selectedDeleteId = null;

    // Cargar permisos
    loadPermissions();

    function loadPermissions() {
        fetch('{{ route("permissions.index") }}')
            .then(response => response.json())
            .then(data => {
                permissionsData = data;
                renderTable(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('permissionsBody').innerHTML = 
                    '<tr><td colspan="7" class="text-center text-danger">Error al cargar los permisos</td></tr>';
            });
    }

    function renderTable(data) {
        const tbody = document.getElementById('permissionsBody');
        
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No hay permisos registrados</td></tr>';
            return;
        }

        tbody.innerHTML = data.map(permission => `
            <tr>
                <td>
                    <input type="checkbox" class="permission-checkbox" value="${permission.id}">
                </td>
                <td><strong>${permission.module}</strong></td>
                <td>${permission.action}</td>
                <td>${permission.category || '-'}</td>
                <td>${permission.description || '-'}</td>
                <td>
                    ${permission.is_system ? '<span class="status-badge status-system">Sistema</span>' : '-'}
                </td>
                <td>
                    <a href="permissions/${permission.id}/edit" class="btn btn-sm btn-warning" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${permission.id}" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');

        attachEventListeners();
    }

    function attachEventListeners() {
        // Evento para eliminar individual
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                selectedDeleteId = this.dataset.id;
                const permission = permissionsData.find(p => p.id == selectedDeleteId);
                
                if (permission.is_system) {
                    alert('No se pueden eliminar permisos de sistema');
                    return;
                }
                
                deleteModal.show();
            });
        });

        // Evento para seleccionar todo
        document.getElementById('selectAllCheckbox').addEventListener('change', function () {
            document.querySelectorAll('.permission-checkbox').forEach(cb => {
                cb.checked = this.checked;
            });
            updateDeleteButton();
        });

        // Evento para checkboxes individuales
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            cb.addEventListener('change', updateDeleteButton);
        });
    }

    function updateDeleteButton() {
        const checked = document.querySelectorAll('.permission-checkbox:checked').length;
        document.getElementById('btnDeleteSelected').style.display = checked > 0 ? 'block' : 'none';
    }

    // Confirmación de eliminación individual
    document.getElementById('btnConfirmDelete').addEventListener('click', function () {
        if (selectedDeleteId) {
            deletePermission(selectedDeleteId);
            deleteModal.hide();
        }
    });

    // Eliminación en lotes
    document.getElementById('btnDeleteSelected').addEventListener('click', function () {
        const selected = Array.from(document.querySelectorAll('.permission-checkbox:checked'))
            .map(cb => cb.value)
            .map(Number);

        if (selected.length > 0) {
            if (confirm('¿Está seguro de eliminar los permisos seleccionados?')) {
                bulkDeletePermissions(selected);
            }
        }
    });

    function deletePermission(id) {
        fetch(`permissions/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadPermissions();
        })
        .catch(error => console.error('Error:', error));
    }

    function bulkDeletePermissions(ids) {
        fetch('{{ route("permissions.bulkDelete") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadPermissions();
        })
        .catch(error => console.error('Error:', error));
    }

    // Filtros
    document.getElementById('filterModule').addEventListener('input', applyFilters);
    document.getElementById('filterCategory').addEventListener('input', applyFilters);
    document.getElementById('filterAction').addEventListener('input', applyFilters);

    function applyFilters() {
        const moduleFilter = document.getElementById('filterModule').value.toLowerCase();
        const categoryFilter = document.getElementById('filterCategory').value.toLowerCase();
        const actionFilter = document.getElementById('filterAction').value.toLowerCase();

        const filtered = permissionsData.filter(permission => {
            return (
                permission.module.toLowerCase().includes(moduleFilter) &&
                (permission.category || '').toLowerCase().includes(categoryFilter) &&
                permission.action.toLowerCase().includes(actionFilter)
            );
        });

        renderTable(filtered);
    }
});
</script>
@endsection
