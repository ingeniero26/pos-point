@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Colores</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Colores
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
                                <h3 class="card-title">Listado de Colores</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addColorModal">
                                            Agregar Color
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="colors-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Código</th>
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
    <div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="addColorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addColorModalLabel">Agregar Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addColorForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="colorName" class="form-label"><b>Nombre de Color</b></label>
                            <input type="text" class="form-control" id="name_color" name="name_color" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label"><b>Código</b></label>
                            <input type="color" name="code" id="code" class="form-control">
                         
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
            fectColors();
            
            function fectColors(){
                $.ajax({
                    url: "{{url('admin/colors/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,colors){
                            let createdAt = dayjs(colors.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(colors.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${colors.name_color}</td>
                                        <td>${colors.code}</td>
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${colors.id}">Editar</button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${colors.id}">Eliminar</button>
                                        </td>
                                      
                                     
                                       
                                    </tr>`;
                        });
                        $('#colors-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer las categorias: ', error);
                    }
        
                });
            }
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let colorId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/colors/edit') }}/" + colorId,
                  type: 'GET', success: function(color)
                   { // Establecer los valores en los campos del modal
                     $('#name_color').val(color.name_color);
                      $('#code').val(color.code); 
                      $('#addColorModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addColorForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/colors/update') }}/" + colorId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addColorModal').modal('hide');
                             fectColors(); $('#addColorForm')[0].reset(); 
                             $('.flashMessage') .text(response.success)
                              .fadeIn() .delay(3000) .fadeOut();
                              setTimeout(function()
                               { location.reload(); }, 2000); },
                               error: function(xhr, status, error) {
                                 console.error('Error al actualizar el registro: ', error);
                                 } });
                                 }); 
                                }, error: function(xhr, status, error) {
                                     console.error('Error al editar la categoría: ', error);
                                     } 
                                    });
            }
            
            // delete
            function handleDelete(e) {
        e.preventDefault();
        const colorId = $(this).data('id');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará permanentemente el registro.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/colors/delete') }}/" + colorId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        fectColors();
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'el registro ha sido eliminada.',
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

         
        });
   </script>
   <script type="text/javascript">
   $(document).ready(function(){
    $('#addColorForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/colors/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addColorModal').modal('hide');
                $('#addColorForm')[0].reset();
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


                                        
   