@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Dashboard RBAC - Control de Acceso</h1>
            <p class="text-muted">Gestión centralizada de roles y permisos</p>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4" id="statsContainer">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Usuarios</h5>
                    <h2 class="text-primary" id="userCount">-</h2>
                    <small class="text-muted">Total de usuarios</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Roles</h5>
                    <h2 class="text-success" id="roleCount">-</h2>
                    <small class="text-muted">Roles disponibles</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Permisos</h5>
                    <h2 class="text-info" id="permissionCount">-</h2>
                    <small class="text-muted">Permisos totales</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Módulos</h5>
                    <h2 class="text-warning" id="moduleCount">-</h2>
                    <small class="text-muted">Módulos del sistema</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de Acciones Rápidas -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('user-roles.list') }}" class="btn btn-primary btn-lg w-100 mb-2">
                                <i class="fas fa-users"></i> Gestionar Roles de Usuarios
                            </a>
                            <small class="text-muted">Asigna roles a usuarios y visualiza sus permisos heredados</small>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('role-permissions.list') }}" class="btn btn-success btn-lg w-100 mb-2">
                                <i class="fas fa-lock"></i> Gestionar Permisos de Roles
                            </a>
                            <small class="text-muted">Asigna permisos específicos a cada rol</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de Usuarios sin Roles -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Usuarios sin Roles Asignados</h5>
                </div>
                <div class="card-body">
                    <div id="usersWithoutRoles" style="max-height: 300px; overflow-y: auto;">
                        <p class="text-muted">Cargando...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Roles sin Permisos -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Roles sin Permisos Asignados</h5>
                </div>
                <div class="card-body">
                    <div id="rolesWithoutPermissions" style="max-height: 300px; overflow-y: auto;">
                        <p class="text-muted">Cargando...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribución de Permisos -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Distribución de Permisos por Módulo</h5>
                </div>
                <div class="card-body">
                    <canvas id="permissionsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos Cambios -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Resumen del Sistema</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Usuarios con Mayor Número de Roles</h6>
                            <div id="topUsers">
                                <p class="text-muted">Cargando...</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Roles Más Utilizados</h6>
                            <div id="topRoles">
                                <p class="text-muted">Cargando...</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Información del Sistema</h6>
                            <ul class="list-unstyled">
                                <li><strong>Permisos de Sistema:</strong> <span id="systemPerms">-</span></li>
                                <li><strong>Permisos Personalizados:</strong> <span id="customPerms">-</span></li>
                                <li><strong>Usuarios Activos:</strong> <span id="activeUsers">-</span></li>
                                <li><strong>Usuarios Inactivos:</strong> <span id="inactiveUsers">-</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart = null;

    document.addEventListener('DOMContentLoaded', function () {
        loadDashboardStats();
    });

    function loadDashboardStats() {
        fetch('/rbac/dashboard-stats')
            .then(response => response.json())
            .then(data => {
                // Actualizar estadísticas
                document.getElementById('userCount').textContent = data.total_users;
                document.getElementById('roleCount').textContent = data.total_roles;
                document.getElementById('permissionCount').textContent = data.total_permissions;
                document.getElementById('moduleCount').textContent = data.total_modules;

                // Información del sistema
                document.getElementById('systemPerms').textContent = data.system_permissions;
                document.getElementById('customPerms').textContent = data.custom_permissions;
                document.getElementById('activeUsers').textContent = data.active_users;
                document.getElementById('inactiveUsers').textContent = data.inactive_users;

                // Usuarios sin roles
                displayUsersWithoutRoles(data.users_without_roles);

                // Roles sin permisos
                displayRolesWithoutPermissions(data.roles_without_permissions);

                // Usuarios principales
                displayTopUsers(data.users_by_role_count);

                // Roles principales
                displayTopRoles(data.roles_by_user_count);

                // Gráfico de permisos
                if (data.permissions_by_module) {
                    createPermissionsChart(data.permissions_by_module);
                }
            })
            .catch(error => {
                console.error('Error loading stats:', error);
            });
    }

    function displayUsersWithoutRoles(users) {
        const container = document.getElementById('usersWithoutRoles');
        
        if (!users || users.length === 0) {
            container.innerHTML = '<p class="text-success"><i class="fas fa-check"></i> Todos los usuarios tienen roles asignados</p>';
            return;
        }

        let html = '<ul class="list-unstyled">';
        users.forEach(user => {
            html += `
                <li class="mb-2 pb-2 border-bottom">
                    <strong>${user.name}</strong> (${user.email})
                    <a href="/admin/user-roles/assign/${user.id}" class="btn btn-sm btn-primary float-end">
                        <i class="fas fa-plus"></i> Asignar
                    </a>
                </li>
            `;
        });
        html += '</ul>';
        container.innerHTML = html;
    }

    function displayRolesWithoutPermissions(roles) {
        const container = document.getElementById('rolesWithoutPermissions');
        
        if (!roles || roles.length === 0) {
            container.innerHTML = '<p class="text-success"><i class="fas fa-check"></i> Todos los roles tienen permisos asignados</p>';
            return;
        }

        let html = '<ul class="list-unstyled">';
        roles.forEach(role => {
            html += `
                <li class="mb-2 pb-2 border-bottom">
                    <strong>${role.name}</strong>
                    <a href="/role-permissions/assign/${role.id}" class="btn btn-sm btn-success float-end">
                        <i class="fas fa-plus"></i> Asignar
                    </a>
                </li>
            `;
        });
        html += '</ul>';
        container.innerHTML = html;
    }

    function displayTopUsers(users) {
        const container = document.getElementById('topUsers');
        
        if (!users || users.length === 0) {
            container.innerHTML = '<p class="text-muted">Sin datos</p>';
            return;
        }

        let html = '<ol>';
        users.slice(0, 5).forEach(user => {
            html += `<li>${user.name} <span class="badge bg-primary">${user.roles_count}</span></li>`;
        });
        html += '</ol>';
        container.innerHTML = html;
    }

    function displayTopRoles(roles) {
        const container = document.getElementById('topRoles');
        
        if (!roles || roles.length === 0) {
            container.innerHTML = '<p class="text-muted">Sin datos</p>';
            return;
        }

        let html = '<ol>';
        roles.slice(0, 5).forEach(role => {
            html += `<li>${role.name} <span class="badge bg-success">${role.users_count}</span></li>`;
        });
        html += '</ol>';
        container.innerHTML = html;
    }

    function createPermissionsChart(data) {
        const ctx = document.getElementById('permissionsChart').getContext('2d');
        
        if (chart) {
            chart.destroy();
        }

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Cantidad de Permisos',
                    data: Object.values(data),
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                        '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
</script>

<style>
    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .btn-lg {
        padding: 15px !important;
        font-size: 1rem !important;
    }
</style>
@endsection
