@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tipo Comprobante Contable</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tipo Comprobante Contable
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
                                <h3 class="card-title">Listado de Comprobantes</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                            Agregar Comprobante Contable
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="category-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Prefijo</th>
                                                <th>Secuencia Actual</th>
                                                <th>Tercero</th>
                                                <th>Inventario</th>
                                                <th>Estado</th>
                                                 <th>Creado</th>
                                            
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
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Agregar Comprobante Contable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="code" class="form-label"><b>Código</b></label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label"><b>Nombre</b></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                       
                        <div class="mb-3">
                            <label for="slug" class="form-label"><b>Prefijo</b></label>
                            <input type="text" class="form-control" id="prefix" name="prefix" >
                        </div>
                        <div class="mb-3">
                            <label for="meta_title" class="form-label"><b>Secuencia Actual</b></label>
                            <input type="text" class="form-control" id="current_sequential" name="current_sequential" >
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label"><b>Modifica Terceros</b></label>
                            <select class="form-select" id="modify_third_parties" name="modify_third_parties">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                      
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label"><b>Meta Modifica Inventario</b></label>
                            <select class="form-select" id="modify_inventories" name="modify_inventories">

                            <option value="1">Sí</option>
                            <option value="0">No</option>
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
            fectCategories();
            
            function fectCategories(){
                $.ajax({
                    url: "{{url('admin/receipt_types/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,category){
                            let createdAt = dayjs(category.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(category.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${category.code}</td>
                                        <td>${category.name}</td>
                                        <td>${category.prefix}</td>
                                        <td>${category.current_sequential}</td>
                                        <td>${category.modify_third_parties}</td>
                                        <td>${category.modify_inventories}</td>
                                        <td>${category.status}</td>

                                        <td>${createdAt}</td>
                                      
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${category.id}">Editar</button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${category.id}">Eliminar</button>
                                        </td>
                                    </tr>`;
                        });
                        $('#category-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                        $('#category-table').DataTable();
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer las categorias: ', error);
                    }
        
                });
            }
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let categoryId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/receipt_types/edit') }}/" + categoryId,
                  type: 'GET', success: function(category)
                   { // Establecer los valores en los campos del modal
                    $('#code').val(category.code);
                     $('#name').val(category.name);
                      $('#prefix').val(category.prefix);
                      $('#current_sequential').val(category.current_sequential);
                      $('#modify_third_parties').val(category.modify_third_parties);
                      $('#modify_inventories').val(category.modify_inventories);
                     

                      $('#addCategoryModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addCategoryForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/receipt_types/update') }}/" + categoryId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addCategoryModal').modal('hide');
                             fectCategories(); $('#addCategoryForm')[0].reset(); 
                             $('.flashMessage') .text(response.success) .fadeIn() .delay(3000) .fadeOut();
                              setTimeout(function() { location.reload(); }, 2000); },
                               error: function(xhr, status, error) {
                                 console.error('Error al actualizar la categoría: ', error);
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
    const categoryId = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará permanentemente el comprobante de contabilidad.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/receipt_types/delete') }}/" + categoryId,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    fectCategories();
                    Swal.fire({
                        title: 'Eliminado!',
                        text: 'La categoría ha sido eliminada.',
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
    $('#addCategoryForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/receipt_types/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addCategoryModal').modal('hide');
                $('#addCategoryForm')[0].reset();
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
                console.error('Error al agregar la categoría: ', error);
            }
        });
    });
});

   </script>

@endsection


                                        
   