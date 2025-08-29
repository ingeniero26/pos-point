@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Usuarios Administradores</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Administradores
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
                        <!--search-->
                   

                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Administradores</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                         Agregar Administrador
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table id="customer-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                                 
                                                <th>Nombre</th>                                                
                                                 <th>Correo</th>
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
    <div class="modal fade" id="addCustomerModal" aria-labelledby="addCustomerModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Agregar Administrador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addCustomerForm">
                        @csrf
                        <div class="row">
                              <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_last_name" class="form-label"><b>Nombre</b></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="">Correo</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>   

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>                                   
                        </div>
                      
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="submitButton">Agregar</button>
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
        fechtCustomers();
        
        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
        }
     

        function fechtCustomers() {
   
    
    $.ajax({
        url: "{{route('admin.admin.fetch')}}",
        type: 'GET',
        data: {
       
            // status: status,
            
        },
        success: function(response){
            let tableBody = '';
            $.each(response.data, function(index, admins){
                let createdAt = dayjs(admins.created_at).format('DD/MM/YYYY h:mm A');
                let updatedAt = dayjs(admins.updated_at).format('DD/MM/YYYY h:mm A');
                let statusText = admins.status == 0 ? 'Inactivo' : 'Activo';
              
                let toggleStatusText = admins.status == 1 ? 'Activar' : 'Desactivar';
                let toggleIcon = admins.status == 1 ? 'fa-toggle-on' : 'fa-toggle-off';

                tableBody += `<tr>
                                <td>${index + 1}</td>
                                                        
                               <td>${admins.name}</td>
                                <td>${admins.email}</td>
                                <td>${statusText}</td>
                                <td>${createdAt}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${admins.id}"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${admins.id}"><i class="fa-solid fa-trash"></i></button>
                                    <button class="btn btn-secondary btn-sm toggle-status-btn" data-id="${admins.id}" data-status="${admins.status}"><i class="fa ${toggleIcon}"></i> ${toggleStatusText}</button>
                                    <button class="btn btn-info btn-sm view" data-id="${admins.id}"><i class="fa-regular fa-eye"></i></button>
                                </td>
                             </tr>`;
            });
            $('#customer-table tbody').html(tableBody);
            $('.edit-btn').on('click', handleEdit);
            $('.delete-btn').on('click', handleDelete);
            $('.view').on('click', handleView);
            $('.toggle-status-btn').on('click', handleToggleStatus);
            $('#customer-table').DataTable();
        },
        error: function(xhr, status, error){
            console.error('Error al leer los contactos: ', error);
        }
    });
}

$(document).ready(function() {
    fechtCustomers();

    $(' #filterStatus').change(function() {
        fechtCustomers();
    });
  
});

 function handleToggleStatus(e) {
    e.preventDefault();
            const button = $(this);
            const customerId = button.data('id');
            const currentStatus = button.data('status');
            const newStatus = currentStatus == 1 ? 0 : 1;

            $.ajax({
                url: "{{ url('admin/type_movement_cash_register/toggle-status') }}/" + customerId,
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
                    fechtCustomers(); // Refrescar la lista de ciudades
                },
                error: function(xhr, status, error) {
                    console.error('Error al cambiar el estado de la responsabilidad: ', error);
                }
            });
        }

        function handleView(e)
        {
            e.preventDefault(); 
            const customerId = $(this).data('id'); 
            window.location.href = "{{ url('admin/type_movement_cash_register') }}/" + customerId;
        }



        // edit
        function handleEdit(e) {
    e.preventDefault();
    let customerId = $(this).data('id');
    $.ajax({
        url: "{{ url('admin/admin/edit') }}/" + customerId,
        type: 'GET',
        success: function(admin) {
            $('#addCustomerModalLabel').text('Editar Administrador');
            $('#submitButton').text('Actualizar');
            $('#addCustomerForm').data('id', customerId);
            $('#name').val(admin.name);
            $('#email').val(admin.email);
            $('#password').val('');
            $('#addCustomerModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener datos del administrador: ', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos del administrador'
            });
        }
    });
}
function handleDelete(e) {
            e.preventDefault();
            const customerId = $(this).data('id');

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
                        url: "{{ url('admin/type_movement_cash_register/delete') }}/" + customerId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fechtCustomers();
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


            
        // delete
    
 

    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#addCustomerForm').on('submit', function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            let submitUrl = $('#submitButton').text() === 'Actualizar' ? 
                "{{route('admin.admin.update', ['id' => ':id'])}}" : 
                "{{route('admin.admin.store')}}";
            if ($('#submitButton').text() === 'Actualizar') {
                submitUrl = submitUrl.replace(':id', $('#addCustomerForm').data('id'));
            }
            
            $.ajax({
                url: submitUrl,
                type: 'POST',
                data: formData,
                success: function(response){
                    $('#addCustomerModal').modal('hide');
                    $('#addCustomerForm')[0].reset();
                    $('.flashMessage')
                    .text(response.success)
                    .fadeIn()
                    .delay(3000)
                    .fadeOut();
                    fechtCustomers();
                },
                error: function(xhr, status, error){
                    console.error('Error en la operación: ', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al procesar la solicitud'
                    });
                }
            });
        });
    
      
    });
</script>


@endsection


                                        
   