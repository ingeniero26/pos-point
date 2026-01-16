@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Asignar Permisos a Rol</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('role-permissions.list') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $role->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label><strong>Descripción:</strong></label>
                        <p>{{ $role->description }}</p>
                    </div>
                    <div class="mb-3">
                        <label><strong>Tipo:</strong></label>
                        <p>
                            @if($role->is_system)
                                <span class="badge bg-warning">Sistema</span>
                                <small class="text-muted d-block mt-2">No se pueden modificar permisos</small>
                            @else
                                <span class="badge bg-success">Personalizado</span>
                            @endif
                        </p>
                    </div>
                    
                    @if(!$role->is_system)
                        <button type="button" class="btn btn-primary w-100" id="btnSavePermissions">
                            <i class="fas fa-save"></i> Guardar Permisos
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @if($role->is_system)
                <div class="alert alert-warning">
                    <i class="fas fa-shield-alt"></i> Este es un rol de sistema. Los permisos no pueden ser modificados.
                </div>
            @endif

            <form id="permissionsForm">
                @csrf

                <div id="errorAlert" class="alert alert-danger" style="display:none;"></div>
                <div id="successAlert" class="alert alert-success" style="display:none;"></div>

                <!-- Módulos y Permisos -->
                <div id="permissionsContainer">
                    @forelse($permissions as $module => $perms)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="form-check mb-0">
                                    <input 
                                        class="form-check-input module-checkbox" 
                                        type="checkbox" 
                                        id="module_{{ str_replace(' ', '_', $module) }}"
                                        data-module="{{ $module }}"
                                        {{ $perms->whereIn('id', $rolePermissions)->count() === $perms->count() && $perms->count() > 0 ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="module_{{ str_replace(' ', '_', $module) }}">
                                        <strong>{{ ucfirst($module) }}</strong>
                                        <small class="text-muted">({{ $perms->count() }} permisos)</small>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($perms as $permission)
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input permission-checkbox module-{{ str_replace(' ', '_', $module) }}" 
                                                    type="checkbox" 
                                                    name="permissions[]" 
                                                    value="{{ $permission->id }}"
                                                    id="perm_{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                    {{ $role->is_system ? 'disabled' : '' }}
                                                >
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    <strong>{{ $permission->action }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $permission->description }}</small>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            No hay permisos disponibles
                        </div>
                    @endforelse
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleId = {{ $role->id }};
    const isSystem = {{ $role->is_system ? 'true' : 'false' }};
    const form = document.getElementById('permissionsForm');
    const saveBtn = document.getElementById('btnSavePermissions');
    const errorAlert = document.getElementById('errorAlert');
    const successAlert = document.getElementById('successAlert');

    // Si es rol de sistema, deshabilitar todo
    if (isSystem) {
        form.querySelectorAll('input').forEach(input => {
            input.disabled = true;
        });
        if (saveBtn) saveBtn.disabled = true;
    }

    // Evento: Marcar/desmarcar todos los permisos de un módulo
    document.querySelectorAll('.module-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const moduleClass = 'module-' + this.dataset.module.replace(/\s+/g, '_');
            const modulePermissions = document.querySelectorAll('.' + moduleClass);
            
            modulePermissions.forEach(perm => {
                perm.checked = this.checked;
            });
        });
    });

    // Evento: Guardar permisos
    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            const selectedPermissions = Array.from(document.querySelectorAll('.permission-checkbox:checked'))
                .map(cb => cb.value);

            fetch(`/role-permissions/store/${roleId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ permissions: selectedPermissions })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    errorAlert.textContent = data.message;
                    errorAlert.style.display = 'block';
                    successAlert.style.display = 'none';
                } else {
                    successAlert.textContent = data.message;
                    successAlert.style.display = 'block';
                    errorAlert.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorAlert.textContent = 'Error al guardar los permisos';
                errorAlert.style.display = 'block';
            });
        });
    }
});
</script>

<style>
    .form-check {
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .form-check:hover {
        background-color: #e9ecef;
    }

    .card-header {
        background-color: #f8f9fa;
    }

    .sticky-top {
        z-index: 100;
    }
</style>
@endsection
