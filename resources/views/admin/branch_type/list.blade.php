@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tipo Sucursal</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tipo Sucursal
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
                                <h3 class="card-title">Listado de Marcas</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addBrandModal">
                                            Agregar Tipo
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="brand-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
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
    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">Agregar Tipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBrandForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="brandName" class="form-label"><b>Nombre </b></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="brandDescription" class="form-label"><b>Descripción</b></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
            fechtBrand();
            
            function fechtBrand(){
                $.ajax({
                    url: "{{url('admin/branch_type/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,brand){
                            let createdAt = dayjs(brand.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(brand.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${brand.name}</td>
                                        <td>${brand.description}</td>
                                        <td>${brand.status ? 'Activo' : 'Inactivo'}</td>
                                       
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${brand.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${brand.id}"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                      
                                    </tr>`;
                        });
                        $('#brand-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer las marcas: ', error);
                    }
        
                });
            }
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let brandId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/branch_type/edit') }}/" + brandId,
                  type: 'GET', success: function(brand)
                   { // Establecer los valores en los campos del modal
                     $('#name').val(brand.name);
                     $('#description').val(brand.description);
                     $('#addBrandModalLabel').text('Editar Tipo Sucursal'); // Cambiar el título
                      
                      $('#addBrandModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addBrandForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/branch_type/update') }}/" + brandId, 
                          type: 'POST', 
                          data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                           success: function(response)
                            { $('#addBrandModal').modal('hide');
                             fechtBrand();
                              $('#addBrandForm')[0].reset(); 
                             $('.flashMessage')
                              .text(response.success)
                               .fadeIn() .delay(3000) .fadeOut();
                              setTimeout(function() { location.reload(); }, 2000); },
                               error: function(xhr, status, error) {
                                 console.error('Error al actualizar la marca: ', error);
                                 } 
                            });
                        }); 
                            }, error: function(xhr, status, error) {
                         console.error('Error al editar la marca: ', error);
                        } 
                });
            }
            
            // delete
        function handleDelete(e) {
             e.preventDefault();
             let brandId = $(this).data('id');

                Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente la marca.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
                 }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/branch_type/delete') }}/" + brandId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        fechtBrand();
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'El registro ha sido eliminado.',
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
            }});
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
    $('#addBrandForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/branch_type/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addBrandModal').modal('hide');
                $('#addBrandForm')[0].reset();
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
                console.error('Error al agregar la Marca: ', error);
            }
        });
    });
});

   </script>

@endsection


                                        
   