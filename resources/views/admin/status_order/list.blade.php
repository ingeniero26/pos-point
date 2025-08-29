@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Estados Orden de Compras</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                               Estados  Orden  de Compra
                            </li>
                        </ol>
                    </div>
                </div> 
            </div> 
        </div>
        <div class="app-content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Orden de Compras</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary" 
                                         data-bs-toggle="modal" data-bs-target="#addItemTypeModal">
                                           <i class="fa fa-plus-circle"></i> Agregar 
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="entity_bank-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>   
                                                <th>Nombre</th>
                                              
                                                 <th>Descripción</th>                                              
                                                 <th>Creado</th>
                                                 <th>Actualizado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main> 
    {{-- modal crear  --}}
    <div class="flashMessage alert alert-success" style="display: none;"></div>
    <div class="modal fade" id="addItemTypeModal" tabindex="-1" aria-labelledby="addItemTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemTypeModalLabel">Agregar Tipo Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemTypeForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="code" class="form-label"><b>Nombre</b></label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="taxCode" class="form-label"><b>Descripción</b></label>
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                  
                      
                  
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
          
    @endsection
   @section('script')
   <script type="text/javascript">
        $(document).ready(function(){
            fetchBankEntity();
            
            function fetchBankEntity() {
    $.ajax({
        url: "{{ url('admin/status_order/data') }}",
        type: 'GET',
        success: function (response) {
            let tableBody = '';

            $.each(response, function (index, costCenters) {
                // Verificar si is_delete = 1 (opcional, si el backend ya filtra)
                if (costCenters.is_delete === 0) {
                    let createdAt = dayjs(costCenters.created_at).format('DD/MM/YYYY h:mm A');
                    let updatedAt = dayjs(costCenters.updated_at).format('DD/MM/YYYY h:mm A');
                    tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${costCenters.name}</td>
                                <td>${costCenters.description}</td>
                                <td>${createdAt}</td>
                                <td>${updatedAt}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${costCenters.id}"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${costCenters.id}"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>`;
                }
            });

            $('#entity_bank-table tbody').html(tableBody);
            $('.edit-btn').on('click', handleEdit);
            $('.delete-btn').on('click', handleDelete);
            $('#entity_bank-table').DataTable();
        },
        error: function (xhr, status, error) {
            console.error('Error al leer los metodos de pago: ', error);
        }
    });
}
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let items_typeId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/status_order/edit') }}/" + items_typeId,
                  type: 'GET',
                   success: function(bank)
                   { // Establecer los valores en los campos del modal
                 
                     
                    $('#code').val(bank.code);
                    $('#name').val(bank.name); 
                     $('#days').val(bank.days);
                     $('#description').val(bank.description);
                      $('#addItemTypeModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addItemTypeForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/status_order/update') }}/" + items_typeId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addItemTypeModal').modal('hide');
                            fetchBankEntity();
                              $('#addItemTypeForm')[0].reset(); 
                             $('.flashMessage') 
                             .text(response.success)
                              .fadeIn()
                               .delay(3000) 
                               .fadeOut();
                              setTimeout(function() { location.reload(); }, 2000);
                             },
                               error: function(xhr, status, error) {
                                 console.error('Error al actualizar el TIPO: ', error);
                                 } });
                                 }); 
                                }, error: function(xhr, status, error) {
                                     console.error('Error al editar el Tipo: ', error);
                                     } 
                                    });
            }
            
            // delete
            function handleDelete(e) {
            e.preventDefault();
            const items_typeId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente el impuesto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/status_order/delete') }}/" + items_typeId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fetchBankEntity();
                            Swal.fire({
                                title: 'Eliminado!',
                                text: 'El Estado ha sido eliminado.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                            $('.flashMessage')
                                .text(response.success)
                                .fadeIn()
                                .delay(3000)
                                .fadeOut();
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar la categoría: ', error);
                        }
                    });
                }
            });
        }

$(document).ready(function() {
    $('.deleteButton').on('click', handleDelete); // Asignar la función de manejo a los botones de eliminación
});

        
        });
   </script>
   <script type="text/javascript">
   $(document).ready(function(){
    $('#addItemTypeForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/status_order/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addItemTypeModal').modal('hide');
                $('#addItemTypeForm')[0].reset();
                $('.flashMessage')
                .text(response.success)
                .fadeIn()
                .delay(3000)
                .fadeOut();
                setTimeout(function(){
                    location.reload();
                }, 2000);
           
            },
            error: function(xhr, status, error){
                console.error('Error al agregar el registro: ', error);
            }
        });
    });
});

   </script>

@endsection


                                        
   