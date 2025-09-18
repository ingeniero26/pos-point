@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Departamentos</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Marcas
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
                                <h3 class="card-title">Listado de Departamentos</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                                            Agregar Departamento
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
                                                <th>Código Dane</th>
                                                 <th>País</th>
                                                <th>Nombre</th>
                                               
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
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Agregar Departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDepartmentForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="dane_code" class="form-label"><b>Código Dane</b></label>
                            <input type="text" class="form-control" id="dane_code" name="dane_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Pais</label>
                            <select name="country_id" id="country_id"
                             class="form-control" name="state">
                                <option value="">Seleccione</option>
                                @foreach ($countries as $key => $item)
                                <option value="{{ $key }}" {{ $key == '46' ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                               </select>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label"><b></b></label>
                            <input type="text" class="form-control" id="name_department" name="name_department" required>
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
                    url: "{{url('admin/department/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,departments){
                            let createdAt = dayjs(departments.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(departments.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${departments.dane_code}</td>
                                         <td>${departments.countries ? departments.countries.country_name : 'N/A'}</td>

                                        <td>${departments.name_department}</td>
                                       
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${departments.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${departments.id}"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                      
                                     
                                       
                                    </tr>`;
                        });
                        $('#department-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                        $('#department-table').DataTable();
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer las marcas: ', error);
                    }
        
                });
            }
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let departmentId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/department/edit') }}/" + departmentId,
                  type: 'GET', success: function(departments)
                   { // Establecer los valores en los campos del modal
                        $('#dane_code').val(departments.dane_code);
                    $('#country_id').val(departments.country_id);
                     $('#name_department').val(departments.name_department);
                      
                      $('#addDepartmentModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addDepartmentForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/department/update') }}/" + departmentId, 
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
                        url: "{{ url('admin/department/delete') }}/" + departmentId,
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
            url: "{{ url('admin/department/store') }}",
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


                                        
   