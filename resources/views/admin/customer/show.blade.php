@extends('layouts.app')
  
    @section('content')
    <div class="container mt-5">
        <h1>Detalles del Cliente</h1>
        <div class="card">
            <div class="card-header">
                <h2>{{ $customer->name }} {{ $customer->last_name }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Número de Identificación:</strong> {{ $customer->identification_number }}</p>
            
                <p><strong>Tipo de Identificación:</strong> {{ $customer->identification_type ? $customer->identification_type->identification_name : 'N/A' }}</p>
                <p><strong>Tipo de Persona:</strong> {{ $customer->type_person == 'legal_entity' ? 'Persona Jurídica' : 'Persona Natural' }}</p>
                <p><strong>Responsabilidad Tributaria:</strong> {{ $customer->tax_liability == 'vat_responsible' ? 'Responsable de IVA' : 'No Responsable de IVA' }}</p>
                <p><strong>Departamento:</strong> {{ $customer->departments ? $customer->departments->name_department : 'N/A' }}</p>
                <p><strong>Ciudad:</strong> {{ $customer->cities ? $customer->cities->city_name : 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $customer->address }}</p>
                <p><strong>Teléfono:</strong> {{ $customer->phone }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Estado:</strong> <span class="{{ $customer->status == 1 ? 'text-danger' : 'text-success' }}">{{ $customer->status == 1 ? 'Inactivo' : 'Activo' }}</span></p>
                <p><strong>Fecha de Creación:</strong> {{ \Carbon\Carbon::parse($customer->created_at)->format('d/m/Y h:i A') }}</p>
                <p><strong>Última Actualización:</strong> {{ \Carbon\Carbon::parse($customer->updated_at)->format('d/m/Y h:i A') }}</p>
            </div>
            <div class="card-footer">
                <button class="btn btn-secondary" onclick="toggleStatus({{ $customer->id }}, {{ $customer->status }})">{{ $customer->status == 1 ? 'Activar' : 'Desactivar' }}</button>
                <button class="btn btn-danger" onclick="deleteContact({{ $customer->id }})">Eliminar</button>
                <a href="{{ url('admin.customer.list') }}" class="btn btn-primary">Volver a la Lista</a>
            </div>
        </div>
    </div>
    
    <script>
     function toggleStatus(customerId, currentStatus) {
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
            fetch(`{{ url('admin/customer/toggle-status') }}/${customerId}`, {
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

    
        function deleteContact(customerId) {
            if (confirm('¿Estás seguro de eliminar este cliente? Esta acción no se puede deshacer.')) {
                fetch(`{{ url('admin/customer/delete') }}/${customerId}`, {
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
                        window.location.href = '{{ url('admin.customer.list') }}';
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
    </script>
    
    
@endsection
