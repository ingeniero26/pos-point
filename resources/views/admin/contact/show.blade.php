@extends('layouts.app')
  
    @section('content')
    <div class="container mt-5">
        <h1>Detalles del Contacto</h1>
        <div class="card">
            <div class="card-header">
                <h2>{{ $contact->contact_name }} {{ $contact->contact_last_name }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Tipo de Contacto:</strong> {{ $contact->type_contact == 'Customer' ? 'Cliente' : 'Proveedor' }}</p>
                <p><strong>Número de Identificación:</strong> {{ $contact->identification_number }}</p>
                <p><strong>Razón Social:</strong> {{ $contact->company_name }}</p>
                <p><strong>Tipo de Identificación:</strong> {{ $contact->identification_type ? $contact->identification_type->identification_name : 'N/A' }}</p>
                <p><strong>Tipo de Persona:</strong> {{ $contact->type_person == 'legal_entity' ? 'Persona Jurídica' : 'Persona Natural' }}</p>
                <p><strong>Responsabilidad Tributaria:</strong> {{ $contact->tax_liability == 'vat_responsible' ? 'Responsable de IVA' : 'No Responsable de IVA' }}</p>
                <p><strong>Departamento:</strong> {{ $contact->departments ? $contact->departments->name_department : 'N/A' }}</p>
                <p><strong>Ciudad:</strong> {{ $contact->cities ? $contact->cities->city_name : 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $contact->address }}</p>
                <p><strong>Teléfono:</strong> {{ $contact->phone }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Estado:</strong> <span class="{{ $contact->status == 1 ? 'text-danger' : 'text-success' }}">{{ $contact->status == 1 ? 'Inactivo' : 'Activo' }}</span></p>
                <p><strong>Fecha de Creación:</strong> {{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y h:i A') }}</p>
                <p><strong>Última Actualización:</strong> {{ \Carbon\Carbon::parse($contact->updated_at)->format('d/m/Y h:i A') }}</p>
            </div>
            <div class="card-footer">
                <button class="btn btn-secondary" onclick="toggleStatus({{ $contact->id }}, {{ $contact->status }})">{{ $contact->status == 1 ? 'Activar' : 'Desactivar' }}</button>
                <button class="btn btn-danger" onclick="deleteContact({{ $contact->id }})">Eliminar</button>
                <a href="{{ url('admin.contact.list') }}" class="btn btn-primary">Volver a la Lista</a>
            </div>
        </div>
    </div>
    
    <script>
        function toggleStatus(contactId, currentStatus) {
            let newStatus = currentStatus == 1 ? 0 : 1;
            if (confirm('¿Estás seguro de cambiar el estado de este contacto?')) {
                fetch(`{{ url('admin/contact/toggle-status') }}/${contactId}`, {
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
                        alert('Estado cambiado exitosamente.');
                        location.reload();
                    } else {
                        alert('Error al cambiar el estado.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cambiar el estado.');
                });
            }
        }
    
        function deleteContact(contactId) {
            if (confirm('¿Estás seguro de eliminar este contacto? Esta acción no se puede deshacer.')) {
                fetch(`{{ url('admin/contact/delete') }}/${contactId}`, {
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
                        window.location.href = '{{ url('admin.contact.list') }}';
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
