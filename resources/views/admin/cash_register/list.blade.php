@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Cajas</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Cajas
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
                                <h3 class="card-title">Listado de Cajas</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                            Agregar Caja
                                        </a>
                                        <a href="" class="btn btn-info">Exportar</a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table id="customer-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th> 
                                                <th>Código</th> 
                                                <th>Caja</th>  
                                               <th>Ubicación</th>
                                               <th>Saldo Máximo</th>
                                                <th>Sucursal</th>
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
                    <h5 class="modal-title" id="addCustomerModalLabel">Agregar Caja Registradora</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label"><b>Código</b></label>
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><b>Nombre</b></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location_description" class="form-label"><b>Ubicación</b></label>
                                    <input type="text" class="form-control" id="location_description" name="location_description" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Saldo Máximo</label>
                                    <input type="text" class="form-control" id="maximun_balance" name="maximun_balance">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="branch_id" class="form-label"><b>Sucursal</b></label>
                                    <select name="branch_id" id="branch_id" class="form-control" required>
                                        <option value="">Seleccione una sucursal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label"><b>Estado</b></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
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
    function duplicateEmail(input) {
        var email = input.value;
        if (email) {
            $.ajax({
                url: '{{ url('admin/person/check-email') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function(response) {
                    if (response.exists) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'El correo electrónico ya está en uso.'
                        }).then(() => {
                            input.value = '';
                        });
                    }
                }
            });
        }
    }

    $(document).ready(function(){
// cargar combo departamentos cuando seleccione un pais

        

        fechtCustomers();
        
        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
        }
     

    function fechtCustomers() {
        let status = $('#filterStatus').val();
        $.ajax({
            url: "{{route('admin.cash_register.fetch')}}",
            type: 'GET',
            data: {
                status: status
            },
            success: function(response){
                let tableBody = '';
                $.each(response, function(index, cash_register){
                    let createdAt = dayjs(cash_register.created_at).format('DD/MM/YYYY h:mm A');
                    let updatedAt = dayjs(cash_register.updated_at).format('DD/MM/YYYY h:mm A');
                    let statusText = cash_register.status ? 'Activo' : 'Inactivo';
                  
                    let toggleStatusText = cash_register.status ? 'Desactivar' : 'Activar';
                    let toggleIcon = cash_register.status ? 'fa-toggle-off' : 'fa-toggle-on';

                    tableBody += `<tr>
                                    <td>${index + 1}</td>
                                    <td>${cash_register.code}</td>
                                    <td>${cash_register.name}</td>
                                    <td>${cash_register.location_description}</td>
                                    <td>${cash_register.maximun_balance}</td>
                                    <td>${cash_register.branch ? cash_register.branch.name : 'N/A'}</td>
                                    <td>${statusText}</td>
                                    <td>${createdAt}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn" data-id="${cash_register.id}"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="${cash_register.id}"><i class="fa-solid fa-trash"></i></button>
                                        <button class="btn btn-secondary btn-sm toggle-status-btn" data-id="${cash_register.id}" data-status="${cash_register.status}"><i class="fa ${toggleIcon}"></i> ${toggleStatusText}</button>
                                        <button class="btn btn-info btn-sm view" data-id="${cash_register.id}"><i class="fa-regular fa-eye"></i></button>
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
                console.error('Error al leer las cajas registradoras: ', error);
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
                url: "{{ url('admin/cash_register/toggle-status') }}/" + customerId,
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
                    console.error('Error al cambiar el estado de la ciudad: ', error);
                }
            });
        }

        function handleView(e)
        {
            e.preventDefault(); 
            const customerId = $(this).data('id'); 
            window.location.href = "{{ url('admin/cash_register') }}/" + customerId;
        }



        // edit
    function handleEdit(e) {
        e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
        let customerId = $(this).data('id');
        $.ajax({
        url: "{{ url('admin/cash_register/edit') }}/" + customerId,
        type: 'GET',
        success: function(customer) { 
            // Establecer los valores en los campos del modal
            $('#addCustomerModalLabel').text('Editar Caja Registradora');
            $('#code').val(customer.code);
            $('#name').val(customer.name);
            $('#location_description').val(customer.location_description);
            $('#maximun_balance').val(customer.maximun_balance);
            $('#branch_id').val(customer.branch_id);
            $('#status').val(customer.status);
                           
            $('#addCustomerModal').modal('show'); 
            
            // Manejar el envío del formulario de edición
            $('#addCustomerForm').off('submit').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario 
                const formData = $(this).serialize();
                $.ajax({ 
                    url: "{{ url('admin/cash_register/update') }}/" + customerId,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addCustomerModal').modal('hide');
                        fechtCustomers(); // Actualiza la lista de productos
                        $('#addCustomerForm')[0].reset();
                        $('.flashMessage')
                            .text(response.success)
                            .fadeIn()
                            .delay(3000)
                            .fadeOut();
                        setTimeout(function() { location.reload(); }, 2000);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al actualizar el cliente: ', error);
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al editar el contacto: ', error);
        }
    });
}
function handleDelete(e) {
            e.preventDefault();
            const customerId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente esta caja.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/cash_register/delete') }}/" + customerId,
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
        // Cargar las sucursales al abrir el modal
        $('#addCustomerModal').on('show.bs.modal', function(){
            $.ajax({
                url: "{{route('admin.branch.fetch')}}",
                type: 'GET',
                success: function(response){
                    let branchSelect = $('#branch_id');
                    branchSelect.empty();
                    branchSelect.append('<option value="">Seleccione una sucursal</option>');
                    
                    $.each(response, function(index, branch){
                        branchSelect.append(`<option value="${branch.id}">${branch.name}</option>`);
                    });
                },
                error: function(xhr, status, error){
                    console.error('Error al cargar las sucursales: ', error);
                }
            });
        });

        // Manejar el envío del formulario
        $('#addCustomerForm').on('submit', function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            
            $.ajax({
                url: "{{url('admin/cash_register/store')}}",
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
                    
                    // Recargar la tabla de cajas registradoras
                    fechtCustomers();
                },
                error: function(xhr, status, error){
                    console.error('Error al agregar la caja registradora: ', error);
                    
                    // Mostrar errores de validación
                    if(xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        
                        for(let field in errors) {
                            errorMessage += errors[field][0] + '\n';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de validación',
                            text: errorMessage
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ha ocurrido un error al procesar la solicitud.'
                        });
                    }
                }
            });
        });
    });
</script>


@endsection


                                        
   