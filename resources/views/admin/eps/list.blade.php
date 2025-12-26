@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">EPS</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                    
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
                                <h3 class="card-title">Listado de Eps</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                                            Agregar EPS
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="department-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nit</th>
                                                <th>Nombre</th>
                                                 <th>Ciudad</th>
                                                 <th>Dirección</th>
                                                 <th>Teléfono</th>
                                                 <th>Email</th>
                                                 <th>Creado</th>
                                                 <th>Estado</th>
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
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Agregar Eps</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDepartmentForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="dane_code" class="form-label"><b>Nit</b></label>
                            <input type="text" class="form-control" id="nit" name="nit" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Nombre Eps</label>
                            <input type="text" class="form-control" id="name_eps" name="name_eps" required>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                    <label for="city_id" class="form-label"><b>Ciudad</b></label>
                                  
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($cities as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Dirección</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
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
            fechtDepartment();
            $('.js-example-basic-single').select2();
            
            
            function fechtDepartment(){
                $.ajax({
                    url: "{{url('admin/eps/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,eps){
                            let createdAt = dayjs(eps.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(eps.updated_at).format('DD/MM/YYYY h:mm A');
                            let statusText = eps.status == 0 ? 'Inactivo' : 'Activo';
              
                            let toggleStatusText = eps.status == 0 ? 'Activar' : 'Desactivar';
                          let toggleIcon = eps.status == 0 ? 'fa-toggle-on' : 'fa-toggle-off';
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${eps.nit}</td>
                                        <td>${eps.name_eps}</td>
                                         <td>${eps.city ? eps.city.city_name : 'N/A'}</td>
                                        <td>${eps.address}</td>
                                        <td>${eps.phone}</td>
                                        <td>${eps.email}</td>
                                        <td>${statusText}</td>
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${eps.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${eps.id}"><i class="fa-solid fa-trash"></i></button>
                                            <button class="btn btn-secondary btn-sm toggle-status-btn" data-id="${eps.id}" data-status="${eps.status}"><i class="fa ${toggleIcon}"></i> ${toggleStatusText}</button>
                                        </td>
                                    </tr>`;
                        });
                        $('#department-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                          $('.toggle-status-btn').on('click', handleToggleStatus);
                        $('#department-table').DataTable();
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer las marcas: ', error);
                    }
        
                });
            }
            // 
        function handleToggleStatus(e) {
            e.preventDefault();
            const button = $(this);
            const epsId = button.data('id');
            const currentStatus = button.data('status');
            const newStatus = currentStatus == 1 ? 0 : 1;

            $.ajax({
                url: "{{ url('admin/eps/toggle-status') }}/" + epsId,
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: newStatus
                },
                success: function(response) {
                    Swal.fire(
                        'Éxito!',
                        response.success,
                        'success'
                    );
                    fechtDepartment(); // Refrescar la lista de eps
                },
                error: function(xhr, status, error) {
                    console.error('Error al cambiar el estado de la eps: ', error);
                }
            });
        }
         
    function handleEdit(e) {
         e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let departmentId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/eps/edit') }}/" + departmentId,
                  type: 'GET', success: function(departments)
                   { // Establecer los valores en los campos del modal
                        $('#nit').val(departments.nit);
                    $('#city_id').val(departments.city_id);
                     $('#name_eps').val(departments.name_eps);
                        $('#address').val(departments.address);
                         $('#phone').val(departments.phone);
                        $('#email').val(departments.email);
                      
                      $('#addDepartmentModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addDepartmentForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/eps/update') }}/" + departmentId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addDepartmentModal').modal('hide');
                            fechtDepartment();
                              $('#addDepartmentForm')[0].reset(); 
                             $('.flashMessage')
                              .text(response.success)
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
            const departmentId = $(this).data('id');

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
                        url: "{{ url('admin/eps/delete') }}/" + departmentId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fechtDepartment();
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
    $('#addDepartmentForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/eps/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addDepartmentModal').modal('hide');
                $('#addDepartmentForm')[0].reset();
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


                                        
   