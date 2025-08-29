@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Sub Categorias</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Sub Categorias
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
                                <h3 class="card-title">Listado de Sub Categorías</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                            Agregar Sub Categoria
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
                                                <th>Categoria</th>
                                                <th>Sub Categoria</th>
                                                <th>Descripción</th>
                                                <th>Slug</th>
                                                <th>Meta Title</th>
                                                <th>Meta Description</th>
                                                <th>Meta Keywords</th>
                                                <th>Estado</th>
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
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Agregar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        {{ @csrf_field() }}
                      <div class="mb-3">
                            <label for="" class="form-label">Categoria</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Seleccione</option>
                                    @foreach ($categories as $key =>$item)
                                    <option value="{{$key }}">{{$item}}</option>
                                           
                                    @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="categoryName" class="form-label"><b>Sub Categoria</b></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label"><b>Descripción</b></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label"><b>Slug</b></label>
                            <input type="text" class="form-control" id="slug" name="slug" >
                        </div>
                        <div class="mb-3">
                            <label for="meta_title" class="form-label"><b>Meta Title</b></label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" >
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label"><b>Meta Description</b></label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label"><b>Meta Keywords</b></label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"></textarea>
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
                    url: "{{url('admin/subcategory/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,subCategories){
                            let createdAt = dayjs(subCategories.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(subCategories.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${subCategories.category.category_name}</td>
                                        <td>${subCategories.name}</td>
                                        <td>${subCategories.description}</td>
                                        <td>${subCategories.slug}</td>
                                        <td>${subCategories.meta_title}</td>
                                        <td>${subCategories.meta_description}</td>
                                        <td>${subCategories.meta_keywords}</td>
                                        <td>${subCategories.status == 1 ? 'Activo' : 'Inactivo'}</td>

                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${subCategories.id}">Editar</button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${subCategories.id}">Eliminar</button>
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
                     url: "{{ url('admin/subcategory/edit') }}/" + categoryId,
                  type: 'GET', success: function(subCategory)
                   { // Establecer los valores en los campos del modal
                     $('#category_id').val(subCategory.category_id);
                        $('#name').val(subCategory.name);
                      $('#description').val(subCategory.description); 
                      $('#slug').val(subCategory.slug);
                      $('#meta_title').val(subCategory.meta_title);
                      $('#meta_description').val(subCategory.meta_description);
                      $('#meta_keywords').val(subCategory.meta_keywords);

                      $('#addCategoryModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addCategoryForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/subcategory/update') }}/" + categoryId, 
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
        text: "Esta acción eliminará permanentemente la categoría.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/subcategory/delete') }}/" + categoryId,
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
    $('#addCategoryForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/subcategory/store') }}",
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


                                        
   