@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Asegurarse de que jQuery esté cargado -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Gestión de Backups</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="#" class="btn btn-success" id="createBackupBtn" data-bs-toggle="modal" data-bs-target="#backupProgressModal">
                <i class="fas fa-plus"></i> Crear Backup
            </a>
        </div>
    </div>

    <!-- Asegurarse de que el botón esté visible -->
    <style>
        #createBackupBtn {
            display: block !important;
            visibility: visible !important;
        }
    </style>

    <!-- Modal de progreso -->
    <div class="modal fade" id="backupProgressModal" tabindex="-1" role="dialog" aria-labelledby="backupProgressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="backupProgressModalLabel">Creando Backup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" 
                                 style="width: 0%" 
                                 id="backupProgressBar">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div id="backupProgressText">Iniciando...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Estado del último backup -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle"></i> Estado del último backup
        </div>
        <div class="card-body">
            @if($last_backup_status['has_backup'])
                <div class="alert alert-success">
                    <p><strong>Último backup:</strong> {{ $last_backup_status['last_backup_date'] }}</p>
                    <p><strong>Tamaño:</strong> {{ $last_backup_status['last_backup_size'] }}</p>
                </div>
            @else
                <div class="alert alert-warning">
                    No se ha creado ningún backup aún.
                </div>
            @endif
        </div>
    </div>

    <!-- Lista de backups -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Listado de Backups</h5>
                <small class="text-muted">(Máximo {{ $maxBackups }} backups)</small>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Tamaño</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($backups as $backup)
                            <tr>
                                <td>{{ $backup['name'] }}</td>
                                <td>{{ $backup['size'] }}</td>
                                <td>{{ $backup['formatted_date'] }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.backups.download', $backup['name']) }}" class="btn btn-primary btn-sm" title="Descargar">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBackupModal" data-backup-name="{{ $backup['name'] }}" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fas fa-box-open fa-2x mb-2 text-muted"></i>
                                    <p class="mb-0">No hay backups disponibles.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteBackupModal" tabindex="-1" aria-labelledby="deleteBackupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBackupModalLabel">Eliminar Backup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que quieres eliminar este backup?
                <p class="mt-2" id="backupToDeleteName"></p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.backups.destroy', '') }}" method="POST" id="deleteBackupForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    // Manejar el evento del modal
    $('#backupProgressModal').on('show.bs.modal', function (e) {
        console.log('Modal mostrado');
        
        // Actualizar la barra de progreso
        let progressBar = $('#backupProgressBar');
        let progressText = $('#backupProgressText');
        let progress = 0;
        
        // Función para actualizar el progreso
        function updateProgress() {
            progress += 10;
            if (progress <= 100) {
                progressBar.css('width', progress + '%');
                progressText.text('Progreso: ' + progress + '%');
                console.log('Progreso actualizado: ' + progress + '%');
                
                // Simular una pausa más realista entre actualizaciones
                setTimeout(updateProgress, Math.random() * 2000 + 500);
            } else {
                // Cuando llega al 100%, mostrar mensaje de finalización
                progressText.text('Backup completado');
                progressBar.css('width', '100%');
                progressBar.removeClass('progress-bar-striped progress-bar-animated');
                progressBar.addClass('bg-success');
            }
        }

        // Iniciar la actualización del progreso
        updateProgress();

        // Hacer la petición AJAX
        console.log('Haciendo petición AJAX...');
        $.ajax({
            url: '{{ route('admin.backups.store') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Respuesta recibida:', response);
                if (response.success) {
                    // Cerrar el modal después de un breve retraso para que vean la finalización
                    setTimeout(() => {
                        $('#backupProgressModal').modal('hide');
                        // Actualizar la lista de backups
                        location.reload();
                    }, 1000);
                } else {
                    alert('Error: ' + response.message);
                    $('#backupProgressModal').modal('hide');
                }
            },
            error: function(xhr) {
                console.error('Error en la petición:', xhr);
                alert('Error al crear el backup: ' + xhr.responseJSON.message);
                $('#backupProgressModal').modal('hide');
            }
        });
    });
</script>
@endsection