@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Gestión de Roles de Usuarios</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('role-permissions.list') }}" class="btn btn-primary">
                <i class="fas fa-lock"></i> Gestionar Permisos de Roles
            </a>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Usuarios y Sus Roles</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="usersTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Compañía</th>
                            <th>Roles Asignados</th>
                            <th>Cantidad de Permisos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="usersBody">
                        <tr>
                            <td colspan="7" class="text-center text-muted">Cargando usuarios...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles -->
<div class="modal fade" id="userDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetailsContent">
                Cargando...
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const userDetailsModal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
    let usersData = [];

    // Cargar usuarios
    loadUsers();

    function loadUsers() {
        fetch('/user-roles/get-users')
            .then(response => response.json())
            .then(data => {
                usersData = data;
                renderTable(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('usersBody').innerHTML = 
                    '<tr><td colspan="7" class="text-center text-danger">Error al cargar usuarios</td></tr>';
            });
    }

    function renderTable(users) {
        const tbody = document.getElementById('usersBody');
        
        if (users.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No hay usuarios</td></tr>';
            return;
        }

        tbody.innerHTML = users.map(user => {
            const roles = user.roles || [];
            const roleNames = roles.map(ur => ur.role?.name || 'N/A').join(', ') || 'Sin roles';
            const status = user.status === 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';

            return `
                <tr>
                    <td><strong>${user.full_name}</strong></td>
                    <td>${user.email}</td>
                    <td>${user.company?.name || 'N/A'}</td>
                    <td>
                        ${roles.length > 0 ? `
                            ${roles.map(ur => `<span class="badge bg-info">${ur.role?.name}</span>`).join(' ')}
                        ` : '<span class="text-muted">Sin roles</span>'}
                    </td>
                    <td>
                        <span class="badge bg-secondary" onclick="viewUserPermissions(${user.id})">
                            Ver permisos
                        </span>
                    </td>
                    <td>${status}</td>
                    <td>
                        <a href="/user-roles/assign/${user.id}" class="btn btn-sm btn-primary" title="Asignar roles">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            `;
        }).join('');
    }

    window.viewUserPermissions = function(userId) {
        fetch(`/user-roles/user-permissions/${userId}`)
            .then(response => response.json())
            .then(data => {
                let html = '<div class="row">';
                
                for (const [module, perms] of Object.entries(data.permissions)) {
                    html += `
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">${module} (${perms.length})</h6>
                                </div>
                                <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                                    <ul class="list-unstyled">
                    `;
                    
                    perms.forEach(perm => {
                        html += `<li class="mb-2"><i class="fas fa-check text-success"></i> <strong>${perm.action}</strong></li>`;
                    });

                    html += `
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                }

                html += `
                    </div>
                    <p class="text-muted mt-3">Total de permisos: <strong>${data.permission_count}</strong></p>
                `;

                document.getElementById('userDetailsContent').innerHTML = html;
                userDetailsModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('userDetailsContent').innerHTML = 
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
