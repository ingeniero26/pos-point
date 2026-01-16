@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Gestión de Permisos por Rol</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user-roles.list') }}" class="btn btn-primary">
                <i class="fas fa-users"></i> Gestionar Roles de Usuarios
            </a>
        </div>
    </div>

    <!-- Tabla de Roles -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Roles y Sus Permisos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="rolesTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre del Rol</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Usuarios</th>
                            <th>Permisos Asignados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="rolesBody">
                        <tr>
                            <td colspan="6" class="text-center text-muted">Cargando roles...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de permisos -->
<div class="modal fade" id="roleDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permisos del Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="roleDetailsContent">
                Cargando...
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleDetailsModal = new bootstrap.Modal(document.getElementById('roleDetailsModal'));
    let rolesData = [];

    // Cargar roles
    loadRoles();

    function loadRoles() {
        fetch('/role-permissions/get-roles')
            .then(response => response.json())
            .then(data => {
                rolesData = data;
                renderTable(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('rolesBody').innerHTML = 
                    '<tr><td colspan="6" class="text-center text-danger">Error al cargar roles</td></tr>';
            });
    }

    function renderTable(roles) {
        const tbody = document.getElementById('rolesBody');
        
        if (roles.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No hay roles</td></tr>';
            return;
        }

        tbody.innerHTML = roles.map(role => {
            const type = role.is_system ? '<span class="badge bg-warning">Sistema</span>' : '<span class="badge bg-success">Personalizado</span>';
            const userCount = role.users?.length || 0;
            const permissionCount = role.permissions?.length || 0;

            return `
                <tr>
                    <td><strong>${role.name}</strong></td>
                    <td>${role.description || 'N/A'}</td>
                    <td>${type}</td>
                    <td>
                        <span class="badge bg-info">${userCount} usuario(s)</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="viewRolePermissions(${role.id})">
                            ${permissionCount} permisos
                        </button>
                    </td>
                    <td>
                        <a href="/role-permissions/assign/${role.id}" class="btn btn-sm btn-primary" title="Editar permisos">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            `;
        }).join('');
    }

    window.viewRolePermissions = function(roleId) {
        fetch(`/role-permissions/role-permissions/${roleId}`)
            .then(response => response.json())
            .then(data => {
                let html = '<div class="row">';
                
                if (Object.keys(data.permissions).length === 0) {
                    html = '<p class="text-muted">Este rol no tiene permisos asignados</p>';
                } else {
                    for (const [module, perms] of Object.entries(data.permissions)) {
                        html += `
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">${module} (${perms.length})</h6>
                                    </div>
                                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                        <ul class="list-unstyled">
                        `;
                        
                        perms.forEach(perm => {
                            html += `<li class="mb-2"><i class="fas fa-check text-success"></i> <strong>${perm.action}</strong><br><small class="text-muted">${perm.description}</small></li>`;
                        });

                        html += `
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    html += '</div>';
                }

                html += `<p class="text-muted mt-3">Total de permisos: <strong>${data.permission_count}</strong></p>`;

                document.getElementById('roleDetailsContent').innerHTML = html;
                roleDetailsModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('roleDetailsContent').innerHTML = 
                    '<p class="text-danger">Error al cargar permisos</p>';
            });
    };
});
</script>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5 !important;
    }

    .badge {
        margin-right: 5px;
    }
</style>
@endsection
