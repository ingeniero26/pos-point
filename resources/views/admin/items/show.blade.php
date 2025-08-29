@extends('layouts.app')

  
    @section('content')
    @section('style')
    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .btn-group .btn {
            flex-grow: 1;
        }
    </style>
    @endsection
    <div class="container mt-5">
            <h1>Detalles del item</h1>
         
                <div class="card">
                    <div class="card-header"> <h5 class="card-title">{{ $item->product_name }}</h5></div>
                    <div class="card-body">

                       
                        <p class="card-text">Codigo de Barras: {{ $item->barcode }}</p>
                        <p class="card-text">Codigo Interno: {{ $item->internal_code }}</p>
                        <p class="card-text">SKU: {{ $item->sku }}</p>
                        <p class="card-text">Referencia: {{ $item->referencie }}</p>

                        <p class="card-text">Precio: ${{ $item->price_total }}</p>
                        <p class="card-text">Categoría: {{ $item->category->category_name }}</p>
                        <p class="card-text">Marca: {{ $item->brand->brand_name }}</p>                  
                        <p class="card-text">Unidad: {{ $item->measure->measure_name }}</p> 
                        <p class="card-text">Impuestos: {{ $item->tax->tax_name }}</p> 
                        <p class="card-text">Moneda: {{ $item->currencies->currency_name }}</p>
                                                
                        <p class="card-text">Descripción: {{ $item->description }}</p>
                        
                        <p class="card-text">Vendido por: @if($item->user) {{ $item->user->name }} @else No hay vendedor @endif</p>
                        <p><strong>Estado:</strong> <span class="{{ $item->status == 1 ? 'text-danger' : 'text-success' }}">{{ $item->status == 1 ? 'Inactivo' : 'Activo' }}</span></p>

                        <p class="card-text">Creado el: {{ $item->created_at->format('d/m/Y') }}</p>
                        <p class="card-text">Actualizado el: {{ $item->updated_at->format('d/m/Y') }}</p>
                        {{-- <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary">Editar</a> --}}
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-secondary" onclick="toggleStatus({{ $item->id }}, {{ $item->status }})">{{ $item->status == 1 ? 'Activar' : 'Desactivar' }}</button>
                        <button class="btn btn-danger" onclick="deleteContact({{ $item->id }})">Eliminar</button>
                        <a href="{{ url('admin/items/list') }}" class="btn btn-primary">Volver a la Lista</a>
                    </div>
    
                </div>
         
    </div>
    <script>
        function toggleStatus(itemId, currentStatus) {
            let newStatus = currentStatus == 1 ? 0 : 1;
           Swal.fire({
           title: '¿Estás seguro?',
           text: "¿Estás seguro de cambiar el estado de este producto?",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Sí, cambiar',
           cancelButtonText: 'No, cancelar',
           }).then((result) => {
           if (result.isConfirmed) {
               fetch(`{{ url('admin/items/toggle-status') }}/${itemId}`, {
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
   
       
           function deleteContact(itemsId) {
               if (confirm('¿Estás seguro de eliminar este item? Esta acción no se puede deshacer.')) {
                   fetch(`{{ url('admin/items/delete') }}/${itemsId}`, {
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
                           window.location.href = '{{ url('admin.items.list') }}';
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
   