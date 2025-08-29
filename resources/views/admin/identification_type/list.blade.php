@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tipo Identificación</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tipo Identificación
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
                                <h3 class="card-title">Listado de Tipo Identificación</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addTypeIdentificationModal">
                                            Agregar Tipo Identificación
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="type-identification-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Abreviatura</th>
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
    <div class="modal fade" id="addTypeIdentificationModal" tabindex="-1" aria-labelledby="addTypeIdentificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTypeIdentificationModalLabel">Agregar Tipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTypeIdentificationForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="categoryName" class="form-label"><b>Nombre</b></label>
                            <input type="text" class="form-control" id="identification_name" name="identification_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="abbreviation" class="form-label"><b>Abreviatura</b></label>
                            <textarea class="form-control" id="abbreviation" name="abbreviation" rows="3"></textarea>
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
            fechtTypeIdentification();
            
            function fechtTypeIdentification(){
                $.ajax({
                    url: "{{url('admin/identification_type/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,type_identification){
                            let createdAt = dayjs(type_identification.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(type_identification.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${type_identification.identification_name}</td>
                                        <td>${type_identification.abbreviation}</td>
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${type_identification.id}">Editar</button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${type_identification.id}">Eliminar</button>
                                        </td>
                                      
                                     
                                       
                                    </tr>`;
                        });
                        $('#type-identification-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer el registro: ', error);
                    }
        
                });
            }
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let type_identificationId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/identification_type/edit') }}/" + type_identificationId,
                  type: 'GET', success: function(type_identification)
                   { // Establecer los valores en los campos del modal
                     $('#identification_name').val(type_identification.identification_name);
                      $('#abbreviation').val(type_identification.abbreviation); 
                      $('#addTypeIdentificationModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addTypeIdentificationForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/identification_type/update') }}/" + type_identificationId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addTypeIdentificationModal').modal('hide');
                             fechtTypeIdentification();
                              $('#addTypeIdentificationForm')[0].reset(); 
                             $('.flashMessage') .text(response.success) 
                             .fadeIn() .delay(3000) .fadeOut();
                              setTimeout(function() { location.reload(); }, 2000); },
                               error: function(xhr, status, error) {
                                 console.error('Error al actualizar el registro: ', error);
                                 } });
                                 }); 
                                }, error: function(xhr, status, error) {
                                     console.error('Error al editar el registro: ', error);
                                     } 
                                    });
            }
            
            // delete
            function handleDelete(e) {
            e.preventDefault();
            const type_identificationId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente el documento.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/identification_type/delete') }}/" + type_identificationId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fechtTypeIdentification();
                            Swal.fire({
                                title: 'Eliminado!',
                                text: 'el registro ha sido eliminado.',
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
                            console.error('Error al eliminar el registro: ', error);
                        }
                    });
                }
            });
}

$(document).ready(function() {
    $('.deleteButton').on('click', handleDelete); // Asignar la función de manejo a los botones de eliminación
});

            // function handleDelete(e) {
            //     e.preventDefault();
            //     const categoryId = $(this).data('id');
            //     if(confirm('Esta seguro de eliminar este registro?'))

            //     {
            //         $.ajax({
            //             url: "{{ url('admin/category/delete') }}/" + categoryId,
            //             type: 'DELETE',
            //             data: {
            //                 _token: "{{ csrf_token() }}",
            //             },
            //             success: function(response){
            //                 fectCategories();
            //                 $('.flashMessage')
            //                 .text(response.success)
            //                 .fadeIn()
            //                 .delay(3000)
            //                 .fadeOut();
            //                 setTimeout(function(){
            //                     location.reload();
            //                 }, 2000);
                        
            //             },
            //         })
            //     }
            // }
        });
   </script>
   <script type="text/javascript">
   $(document).ready(function(){
    $('#addTypeIdentificationForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/identification_type/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addTypeIdentificationModal').modal('hide');
                $('#addTypeIdentificationForm')[0].reset();
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


                                        
   