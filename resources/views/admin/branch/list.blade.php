@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Sucursales</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Sucursales
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
                                <h3 class="card-title">Listado de Sucursales</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                            Agregar Sucursal
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
                                                <th>Tipo Sucursal</th>
                                               <th>Sucursal</th>  
                                              
                                               <th>Direccion</th>
                                                <th>Teléfono</th>
                                                <th>Correo Electrónico</th>
                                                <th>País</th>                       
                                                <th>Departamento</th>
                                                <th>Ciudad</th>
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
                    <h5 class="modal-title" id="addCustomerModalLabel">Agregar Sucursal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 id="nombreRazonSocial">
                                <div class="mb-3">
                                    <label for="branch_type_id" class="form-label"><b>Tipo Sucursal</b></label>
                                    <select name="branch_type_id" id="branch_type_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($branchTypes as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="contact_name" class="form-label"><b>Sucursal</b></label>
                                    <input type="text" class="form-control" id="name" name="name" >
                                </div>
                            </div>
                            <div class="col-md-3" id="apellidoContacto">
                                <div class="mb-3">
                                    <label for="contact_last_name" class="form-label"><b>Dirección</b></label>
                                    <input type="text" class="form-control" id="address" name="address" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                    onblur="duplicateEmail(this)">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                <label for="">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                            </div>
                        </div>
                        
                      
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Pais</label>
                                 <select name="country_id" id="country_id" class="form-control">
                                     <option value="">Seleccione</option>
                                       @foreach ($countries as $key =>$item)
                                       <option value="{{ $key }}" {{ $key == '46' ? 'selected' : '' }}>{{ $item }}</option>
                                           
                                       @endforeach
                                    </select>

                            </div>
                 
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="department_id" class="form-label"><b>Departamento</b></label>
                                    <select name="department_id" id="department_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($departments as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
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
  
    $('#country_id').change(function() {
        var countryId = $(this).val(); // Obtener el valor seleccionado del país
        // Limpiar el combo de departamentos
        $('#department_id').html('<option value="">Seleccione</option>');

        // Si se seleccionó un país válido
        if (countryId) {
            // Hacer una solicitud AJAX para obtener los departamentos
            $.ajax({
                url: "{{ url('admin/person/get_departments') }}/" + countryId,
               // url: '{{ url('admin/person/get_departments') }}', // Ruta en tu backend para obtener los departamentos
                type: 'get',
                data: {
                    country_id: countryId // Enviar el ID del país seleccionado
                 
                },
                success: function(response) {
                    // Si la respuesta es exitosa, llenar el combo de departamentos
                    if (response.departments) {
                        $.each(response.departments, function(key, value) {
                            $('#department_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al obtener los departamentos');
                }
            });
        }
    });
    
    // cargar combo ciudades cuando seleccione un departamento
    $('#department_id').change(function() {
        var departmentId = $(this).val(); // Obtener el valor seleccionado del departamento
        // Limpiar el combo de ciudades
        $('#city_id').html('<option value="">Seleccione</option>');
        // Si se seleccionó un departamento válido
        if (departmentId) {
            // Hacer una solicitud AJAX para obtener las ciudades
            $.ajax({
                url: "{{ url('admin/person/get_cities') }}/" + departmentId,
                type: 'get',
                data: {
                    department_id: departmentId // Enviar el ID del departamento seleccionado
                },
                success: function(response) {
                    // Si la respuesta es exitosa, llenar el combo de ciudades
                    if (response.cities) {
                        $.each(response.cities, function(key, value) {
                            $('#city_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al obtener las ciudades');
                }
            });
        }
    });


        

        fechtCustomers();
        
        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
        }
     

    function fechtCustomers() {
        let typeContact = $('#filterTypeContact').val();
        let status = $('#filterStatus').val();
        let startDate = $('#startDate').val(); 
        let endDate = $('#endDate').val();
    
        $.ajax({
        url: "{{route('admin.branch.fetch')}}",
        type: 'GET',
        data: {
       
            status: status,
            
        },
        success: function(response){
            let tableBody = '';
            $.each(response, function(index, customer){
                let createdAt = dayjs(customer.created_at).format('DD/MM/YYYY h:mm A');
                let updatedAt = dayjs(customer.updated_at).format('DD/MM/YYYY h:mm A');
                let statusText = customer.status == 1 ? 'Activo' : 'Inactivo';
                let toggleStatusText = customer.status == 1 ? 'Desactivar' : 'Activar';
                let toggleIcon = customer.status == 1 ? 'fa-toggle-off' : 'fa-toggle-on';

                tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${customer.branch_types ? customer.branch_types.name : 'N/A'}</td>
                                
                                <td>${customer.name}</td>
                               <td>${customer.address}</td>
                                <td>${customer.phone}</td>
                                <td>${customer.email}</td>
                              
                                <td>${customer.countries ? customer.countries.country_name : 'N/A'}</td>
                                <td>${customer.departments ? customer.departments.name_department : 'N/A'}</td>
                                <td>${customer.cities ? customer.cities.city_name : 'N/A'}</td>
                               
                                <td>${statusText}</td>
                                <td>${createdAt}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${customer.id}"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${customer.id}"><i class="fa-solid fa-trash"></i></button>
                                    <button class="btn btn-secondary btn-sm toggle-status-btn" data-id="${customer.id}" data-status="${customer.status}"><i class="fa ${toggleIcon}"></i> ${toggleStatusText}</button>
                                    <button class="btn btn-info btn-sm view" data-id="${customer.id}"><i class="fa-regular fa-eye"></i></button>
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
                url: "{{ url('admin/branch/toggle-status') }}/" + customerId,
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
            window.location.href = "{{ url('admin/branch') }}/" + customerId;
        }



        // edit
        function handleEdit(e) {
    e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
    let customerId = $(this).data('id');
    $.ajax({
        url: "{{ url('admin/branch/edit') }}/" + customerId,
        type: 'GET',
        success: function(customer) { 
            // Establecer los valores en los campos del modal
          
            $('#branch_type_id').val(customer.branch_type_id);
            $('#identification_number').val(customer.identification_number);
            $
            $('#name').val(customer.name);
        
            $('#department_id').val(customer.department_id);
            $('#city_id').val(customer.city_id);
            $('#address').val(customer.address);
            $('#phone').val(customer.phone);
           $('#email').val(customer.email);
            
                       
            $('#addCustomerModal').modal('show'); 
            
            // Manejar el envío del formulario de edición
            $('#addCustomerForm').off('submit').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario 
                const formData = $(this).serialize();
                $.ajax({ 
                    url: "{{ url('admin/branch/update') }}/" + customerId,
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
                text: "Esta acción eliminará permanentemente el contacto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/branch/delete') }}/" + customerId,
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
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#addCustomerForm').on('submit', function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{route('admin.branch.store')}}",
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
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error){
                    console.error('Error al agregar el cliente: ', error);
                }
            });
        });
    
      
    });
</script>


@endsection


                                        
   