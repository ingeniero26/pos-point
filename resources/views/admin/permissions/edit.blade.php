@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Editar Permiso</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <form id="permissionForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="module" class="form-label">Módulo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="module" name="module" 
                                placeholder="Ej: usuarios, inventario, ventas" required>
                            <small class="text-muted">Nombre del módulo al que pertenece este permiso</small>
                        </div>

                        <div class="mb-3">
                            <label for="action" class="form-label">Acción <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="action" name="action" 
                                placeholder="Ej: crear, editar, eliminar, ver" required>
                            <small class="text-muted">Tipo de acción permitida</small>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="category" name="category" 
                                placeholder="Ej: administración, operación, reporte">
                            <small class="text-muted">Categoría para agrupar permisos relacionados</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" 
                                rows="4" placeholder="Describe el propósito de este permiso"></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_system" name="is_system" value="1">
                                <label class="form-check-label" for="is_system">
                                    Permiso de Sistema
                                </label>
                                <small class="text-muted d-block">
                                    Marca esta opción si este permiso es crítico para el funcionamiento del sistema
                                </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div id="errorAlert" class="alert alert-danger" style="display:none;"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block w-100">
                                    <i class="fas fa-save"></i> Actualizar Permiso
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('permissions.list') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const permissionId = '{{ $id ?? null }}';
    const form = document.getElementById('permissionForm');
    const errorAlert = document.getElementById('errorAlert');

    // Cargar datos del permiso
    if (permissionId) {
        fetch(`{{ route('permissions.edit', '') }}/${permissionId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('module').value = data.module;
                document.getElementById('action').value = data.action;
                document.getElementById('category').value = data.category || '';
                document.getElementById('description').value = data.description || '';
                document.getElementById('is_system').checked = data.is_system;
            })
            .catch(error => {
                console.error('Error:', error);
                errorAlert.style.display = 'block';
                errorAlert.textContent = 'Error al cargar el permiso.';
            });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = {
            module: document.getElementById('module').value,
            action: document.getElementById('action').value,
            category: document.getElementById('category').value || null,
            description: document.getElementById('description').value || null,
            is_system: document.getElementById('is_system').checked ? 1 : 0
        };

        fetch(`{{ route('permissions.update', '') }}/${permissionId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                window.location.href = '{{ route("permissions.list") }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorAlert.style.display = 'block';
            errorAlert.textContent = 'Error al actualizar el permiso. Intente nuevamente.';
        });
    });
});
</script>
@endsection
