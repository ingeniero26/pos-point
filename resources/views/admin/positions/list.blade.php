@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Cargos de la empresa</h3>
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
                                <h3 class="card-title">Listado de Cargos de la empresa</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                                            Agregar Cargo
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
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Area(Departamento)</th>
                                                <th>Nivel</th>
                                                <th>Salario minímo</th>
                                                <th>Salario Máximo</th>
                                                <th>Requerimientos</th>
                                                <th>Responsabilidades</th>
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
                    <h5 class="modal-title" id="addDepartmentModalLabel">Agregar Cargo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDepartmentForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="dane_code" class="form-label"><b>Nombre Cargo</b></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="dane_code" class="form-label"><b>Descripción</b></label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="area_id" class="form-label"><b>Área (Departamento)</b></label>
                            <select class="form-select" id="area_id" name="area_id" required>
                                <option value="">Seleccione un área</option>
                                  @foreach ($areas as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                               
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label"><b>Nivel</b></label>
                            <input type="text" class="form-control" id="level" name="level" required>
                        </div>
                        <div class="mb-3">
                            <label for="min_salary" class="form-label"><b>Salario Minímo</b></label>
                            <input type="number" class="form-control" id="min_salary" name="min_salary" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_salary" class="form-label"><b>Salario Máximo</b></label>
                            <input type="number" class="form-control" id="max_salary" name="max_salary" required>
                        </div>
                        <div class="mb-3">
                            <label for="requirements" class="form-label"><b>Requerimientos</b></label>
                            <textarea class="form-control" id="requirements" name="requirements" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="responsibilities" class="form-label"><b>Responsabilidades</b></label>
                            <textarea class="form-control" id="responsibilities" name="responsibilities" rows="3" required></textarea>
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
                    url: "{{url('admin/positions/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response.data, function(index,eps){
                            let createdAt = dayjs(eps.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(eps.updated_at).format('DD/MM/YYYY h:mm A');
                            let statusText = eps.status == 0 ? 'Inactivo' : 'Activo';
              
                            let toggleStatusText = eps.status == 0 ? 'Activar' : 'Desactivar';
                            let toggleIcon = eps.status == 0 ? 'fa-toggle-on' : 'fa-toggle-off';
                            let areaName = eps.area ? eps.area.name : 'Sin área';
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${eps.name}</td>
                                        <td>${eps.description}</td>
                                        <td>${areaName}</td>
                                        <td>${eps.level}</td>
                                        <td>${eps.min_salary}</td>
                                        <td>${eps.max_salary}</td>
                                        <td>${eps.requirements}</td>
                                        <td>${eps.responsibilities}</td>
                                        <td>${createdAt}</td>
                                        <td>${statusText}</td>
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
                url: "{{ url('admin/positions/toggle-status') }}/" + epsId,
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
    e.preventDefault();
    let departmentId = $(this).data('id');
    
    $.ajax({
        url: "{{ url('admin/positions/edit') }}/" + departmentId,
        type: 'GET',
        success: function(departments) {
            // Establecer los valores en los campos del modal
            $('#name').val(departments.name);
            $('#description').val(departments.description);
            $('#area_id').val(departments.area_id);
            $('#level').val(departments.level);
            $('#min_salary').val(departments.min_salary);
            $('#max_salary').val(departments.max_salary);
            $('#requirements').val(departments.requirements);
            $('#responsibilities').val(departments.responsibilities);
            
            // Cambiar el título del modal a "Editar"
            $('#addDepartmentModal .modal-title').text('Editar Cargo');
            
            // Cambiar el texto del botón de submit a "Actualizar" o "Editar"
            $('#addDepartmentForm button[type="submit"]').text('Actualizar');
            
            $('#addDepartmentModal').modal('show');
            
            // Manejar el envío del formulario de edición
            $('#addDepartmentForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                
                $.ajax({
                    url: "{{ url('admin/positions/update') }}/" + departmentId,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addDepartmentModal').modal('hide');
                        fechtDepartment();
                        $('#addDepartmentForm')[0].reset();
                        
                        // Restaurar los textos originales del modal
                        $('#addDepartmentModal .modal-title').text('Agregar Cargo');
                        $('#addDepartmentForm button[type="submit"]').text('Guardar');
                        
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
                        console.error('Error al actualizar el registro: ', error);
                    }
                });
            });
        },
        error: function(xhr, status, error) {
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
                        url: "{{ url('admin/positions/delete') }}/" + departmentId,
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
            url: "{{ url('admin/positions/store') }}",
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


                                        
   