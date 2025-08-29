@extends('layouts.app')
  
    @section('content')
    <div class="container mt-5">
        <h1>Detalles del Proveedor</h1>
        <div class="card">
            <div class="card-header">
                <h2>{{ $supplier->company_name }} {{ $supplier->identification_number }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Número de Identificación:</strong> {{ $supplier->identification_number }}</p>
            
                <p><strong>Tipo de Identificación:</strong> {{ $supplier->identification_type ? $supplier->identification_type->identification_name : 'N/A' }}</p>
                <p><strong>Tipo de Persona:</strong> {{ $supplier->type_person == 'legal_entity' ? 'Persona Jurídica' : 'Persona Natural' }}</p>
                <p><strong>Responsabilidad Tributaria:</strong> {{ $supplier->tax_liability == 'vat_responsible' ? 'Responsable de IVA' : 'No Responsable de IVA' }}</p>
                <p><strong>Departamento:</strong> {{ $supplier->departments ? $supplier->departments->name_department : 'N/A' }}</p>
                <p><strong>Ciudad:</strong> {{ $supplier->cities ? $supplier->cities->city_name : 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $supplier->address }}</p>
                <p><strong>Teléfono:</strong> {{ $supplier->phone }}</p>
                <p><strong>Email:</strong> {{ $supplier->email }}</p>
                <p><strong>Estado:</strong> <span class="{{ $supplier->status == 1 ? 'text-danger' : 'text-success' }}">{{ $supplier->status == 1 ? 'Inactivo' : 'Activo' }}</span></p>
                <p><strong>Fecha de Creación:</strong> {{ \Carbon\Carbon::parse($supplier->created_at)->format('d/m/Y h:i A') }}</p>
                <p><strong>Última Actualización:</strong> {{ \Carbon\Carbon::parse($supplier->updated_at)->format('d/m/Y h:i A') }}</p>
            </div>
            <div class="card-footer">
                <button class="btn btn-secondary" onclick="toggleStatus({{ $supplier->id }}, {{ $supplier->status }})">{{ $supplier->status == 1 ? 'Activar' : 'Desactivar' }}</button>
                <button class="btn btn-danger" onclick="deleteContact({{ $supplier->id }})">Eliminar</button>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#sendEmailModal">Enviar Correo</button>

                <a href="{{ url('admin.supplier.list') }}" class="btn btn-primary">Volver a la Lista</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendEmailModalLabel">Enviar Correo a {{ $supplier->company_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sendEmailForm">
                    @csrf
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailBody" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="emailBody" name="body" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
    <script>
     function toggleStatus(supplierId, currentStatus) {
    let newStatus = currentStatus == 1 ? 0 : 1;
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Estás seguro de cambiar el estado de este cliente?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cambiar',
        cancelButtonText: 'No, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ url('admin/supplier/toggle-status') }}/${supplierId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Cambiado!',
                        'Estado cambiado exitosamente.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        'Error al cambiar el estado.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Error al cambiar el estado.',
                    'error'
                );
            });
        }
    });
}

    
        function deleteContact(supplierId) {
            if (confirm('¿Estás seguro de eliminar este cliente? Esta acción no se puede deshacer.')) {
                fetch(`{{ url('admin/supplier/delete') }}/${supplierId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Contacto eliminado exitosamente.');
                        window.location.href = '{{ url('admin.supplier.list') }}';
                    } else {
                        alert('Error al eliminar el contacto.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el contacto.');
                });
            }
        }
        document.getElementById('sendEmailForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const subject = document.getElementById('emailSubject').value;
        const body = document.getElementById('emailBody').value;
        
        fetch(`{{ url('admin/supplier/send-email') }}/${{{ supplier->id }}}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ subject: subject, body: body })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire(
                    '¡Enviado!',
                    'Correo enviado exitosamente.',
                    'success'
                );
                document.getElementById('sendEmailForm').reset();
                $('#sendEmailModal').modal('hide');
            } else {
                Swal.fire(
                    'Error',
                    'Error al enviar el correo.',
                    'error'
                );
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire(
                'Error',
                'Error al enviar el correo.',
                'error'
            );
        });
    });
    </script>



    
    
@endsection
