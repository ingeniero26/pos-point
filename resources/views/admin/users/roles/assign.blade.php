@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Asignar Roles a Usuarios</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user-roles.list') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $user->full_name }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label><strong>Email:</strong></label>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label><strong>Compañía:</strong></label>
                        <p>{{ $user->company->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label><strong>Estado:</strong></label>
                        <p>
                            @if($user->status == 1)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Asignar Roles</h5>
                </div>
                <div class="card-body">
                    <form id="rolesForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Roles Disponibles</label>
                            <div id="rolesList">
                                @forelse($roles as $role)
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input role-checkbox" 
                                            type="checkbox" 
                                            name="roles[]" 
                                            value="{{ $role->id }}"
                                            id="role_{{ $role->id }}"
                                            {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                            <strong>{{ $role->name }}</strong>
                                            @if($role->is_system)
                                                <span class="badge bg-warning">Sistema</span>
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $role->description }}</small>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted">No hay roles disponibles</p>
                                @endforelse
                            </div>
                        </div>

                        <div id="errorAlert" class="alert alert-danger" style="display:none;"></div>
                        <div id="successAlert" class="alert alert-success" style="display:none;"></div>

                        <div class="btn-group w-100" role="group">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-save"></i> Guardar Roles
                            </button>
                            <button type="reset" class="btn btn-secondary flex-grow-1">
                                <i class="fas fa-redo"></i> Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Permisos del Usuario -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Permisos del Usuario (según roles)</h5>
                </div>
                <div class="card-body">
                    <div id="userPermissionsContainer" class="table-responsive">
                        <p class="text-muted">Cargando permisos...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const userId = {{ $user->id }};
    const form = document.getElementById('rolesForm');
    const errorAlert = document.getElementById('errorAlert');
    const successAlert = document.getElementById('successAlert');

    // Cargar permisos del usuario
    loadUserPermissions();

    function loadUserPermissions() {
        fetch(`/user-roles/user-permissions/${userId}`)
            .then(response => response.json())
            .then(data => {
                displayPermissions(data.permissions);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function displayPermissions(permissions) {
        const container = document.getElementById('userPermissionsContainer');
        
        if (Object.keys(permissions).length === 0) {
            container.innerHTML = '<p class="text-muted">El usuario aún no tiene permisos asignados</p>';
            return;
        }

        let html = '<div class="row">';
        for (const [module, perms] of Object.entries(permissions)) {
            html += `
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">${module}</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
            `;
            
            perms.forEach(perm => {
                html += `
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success"></i>
                        <strong>${perm.action}</strong>
                        <br>
                        <small class="text-muted">${perm.description}</small>
                    </li>
                `;
            });

            html += `
                        </ul>
                    </div>
                </div>
            `;
        }
        html += '</div>';

        container.innerHTML = html;
    }

    // Guardar roles
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const selectedRoles = Array.from(document.querySelectorAll('.role-checkbox:checked'))
            .map(cb => cb.value);

        fetch(`/user-roles/store/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ roles: selectedRoles })
        })
        .then(response => response.json())
        .then(data => {
            successAlert.textContent = data.message;
            successAlert.style.display = 'block';
            errorAlert.style.display = 'none';
            
            // Recargar permisos
            setTimeout(() => {
                loadUserPermissions();
            }, 500);
        })
        .catch(error => {
            console.error('Error:', error);
            errorAlert.textContent = 'Error al guardar los roles';
            errorAlert.style.display = 'block';
        });
    });

    // Actualizar permisos cuando cambian los roles
    document.querySelectorAll('.role-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            loadUserPermissions();
        });
    });
});
</script>

<style>
    .table-responsive {
        min-height: 200px;
    }
    
    .form-check {
        padding: 10px;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    
    .form-check:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
