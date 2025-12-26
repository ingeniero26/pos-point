@extends('layouts.app')

  
    @section('content')
    @section('style')
    <style>
        .customer-card .card-actions {
    display: none;
}
.customer-card:hover .card-actions {
    display: block !important;
}
        </style>
    @endsection
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Clientes/Proveedores</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Terceros
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
                       
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Terceros</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                            Agregar Tercero
                                        </a>
                                        <a href="" class="btn btn-info">Exportar</a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Filtros</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="filter_type_third">Tipo de Tercero</label>
                                                            <select name="filter_type_third" id="filter_type_third" class="form-control">
                                                                <option value="">Todos</option>
                                                                @foreach ($type_third as $key => $item)
                                                                    <option value="{{ $key }}">{{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="filter_status">Tipo Persona</label>
                                                            <select name="filter_type_person" id="filter_type_person" class="form-control">
                                                                <option value="">Todos</option>
                                                                @foreach ($type_person as $key => $item)
                                                                    <option value="{{ $key }}">{{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                           
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                                
                                <div class="table-responsive">
                                    <table id="customer-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>  
                                                <th>Tipo Persona</th>                                               
                                                 <th>Tipo Documento</th>
                                                 <th>Número</th>  
                                                 <th>Digito Verificador</th>
                                                 <th>Empresa</th>  
                                                 <th>Razon Comercial</th>                                            
                                                <th>Tercero</th>
                                                <th>Régimen</th>   
                                                <th>Obligación</th>  
                                                <th>CIUU</th>
                                                <th>Contribuyente</th>
                                                <th>Autorretedor</th>
                                                <th>Actividad ICA</th>
                                                <th>Tasa ICA</th>
                                                <th>Registro Comercial</th>
                                                <th>Fecha Registro</th>
                                                <th>País</th>                       
                                                <th>Departamento</th>
                                                <th>Ciudad</th>
                                                <th>Direccion</th>
                                                 <th>Teléfono</th>
                                                 <th>Correo Electrónico</th>
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
                    <h5 class="modal-title" id="addCustomerModalLabel">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addCustomerForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for=""><b>Tipo Tercero </b></label>
                                 <select name="type_third_id" id="type_third_id" class="form-control">
                                     <option value="">Seleccione</option>
                                       @foreach ($type_third as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>                           
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label"><b>Tipo Documento</b></label>
                                     <select name="identification_type_id" id="identification_type_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($identification_type as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="identification_number" class="form-label"><b>Número de Identificación</b></label>
                                    <input type="text" class="form-control"
                                     id="identification_number" name="identification_number" onblur="duplicateIdentification(this)" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="dv" class="form-label"><b>Digito</b></label>
                                    <input type="text" class="form-control" id="dv" name="dv">
                                </div>
                            </div>
                        </div>
                        {{-- nombre empresa ocultar si es un cliente --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for=""><b>Nombre Empresa</b></label>
                                <input type="text" class="form-control"
                                  id="company_name"
                                 name="company_name">
                            </div>
                            <div class="col-md-6">
                                <label for=""><b>Nombre Comercial</b></label>
                                <input type="text" class="form-control"
                                  id="name_trade"
                                 name="name_trade">
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-md-6" id="">
                                <div class="mb-3">
                                    <label for="contact_name" class="form-label"><b>Primer Nombre </b></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" >
                                </div>
                            </div>
                            <div class="col-md-6" id="">
                                <div class="mb-3">
                                    <label for="second_name" class="form-label"><b>Segundo Nombre </b></label>
                                    <input type="text" class="form-control" id="second_name" name="second_name" >
                                </div>
                            </div>
                            <div class="col-md-6" id="apellidoContacto">
                                <div class="mb-3">
                                    <label for="contact_last_name" class="form-label"><b>1er Apellido </b></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" >
                                </div>
                            </div>
                            <div class="col-md-6" id="">
                                <div class="mb-3">
                                    <label for="second_last_name" class="form-label"><b>2do Apellido </b></label>
                                    <input type="text" class="form-control" 
                                    id="second_last_name" name="second_last_name" >
                                </div>
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Tipo Persona </label>
                                 <select name="type_person_id" id="type_person_id" class="form-control">
                                     <option value="">Seleccione</option>
                                       @foreach ($type_person as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type_regimen" class="form-label"><b>Tipo de Regimen</b></label>
                                    <select name="type_regimen_id" id="type_regimen_id"
                                     class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($type_regimen as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                   <label for=""><b>Tipo Obligaciòn</b></label>
                                   <select name="type_liability_id" id="type_liability_id"
                                   class="form-control">
                                      <option value="">Seleccione</option>
                                     @foreach ($type_liability as $key =>$item)
                                     <option value="{{$key }}">{{$item}}</option>
                                         
                                     @endforeach
                                  </select>
                                </div>
                            </div>
                           
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <label for=""><b>CIUU</b></label>
                                <input type="text" class="form-control"
                                  id="ciiu_code"
                                 name="ciiu_code">
                            </div>
                            <div class="col-md-3">
                                <label for="">Gran Contribuyente</label>
                                <select name="great_taxpayer" id="great_taxpayer" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Auto Retenido</label>
                                <select name="self_withholder" id="self_withholder" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Actividad ICA</label>
                               <input type="text" class="form-control"
                                  id="ica_activity"
                                 name="ica_activity">
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-3">
                            <label for="">Tasa ICA</label>
                               <input type="number" class="form-control"
                                  id="ica_rate"
                                 name="ica_rate">
                            </div>
                            <div class="col-md-3">
                                <label for="">Registro Comercial</label>
                               <input type="text" class="form-control"
                                  id="commercial_registry"
                                 name="commercial_registry">
                            </div>
                            <div class="col-md-3">
                                <label for="">Fecha Registro</label>
                               <input type="date" class="form-control"
                                  id="registration_date"
                                 name="registration_date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Pais</label>
                                 <select name="country_id" id="country_id" class="form-control">
                                     <option value="">Seleccione</option>
                                       @foreach ($countries as $key =>$item)
                                       <option value="{{ $key }}" {{ $key == '46' ? 'selected' : '' }}>{{ $item }}</option>
                                           
                                       @endforeach
                                    </select>

                            </div>
                 
                            <div class="col-md-3">
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="address" class="form-label"><b>Dirección</b></label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone" class="form-label"><b>Teléfono</b></label>
                                    <input type="text" class="form-control" 
                                    id="phone" name="phone" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email" class="form-label"><b>Email</b></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                     onblur="duplicateEmail(this)">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header"> <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Comentarios
                                            
                                        </button> </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                        <div class="accordion-body"> 
                                             <textarea class="form-control" id="comment" name="comment" rows="3">

                                             </textarea>
                                        </div>
                                    </div>
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

   function duplicateIdentification(input) {
    var identification_number = input.value;
    if (identification_number) {
        $.ajax({
            url: '{{ url('admin/person/check-identification') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                identification_number: identification_number
            },
            success: function(response) {
                if (response.exists) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El número de identificación ya está en uso.'
                    }).then(() => {
                        input.value = '';
                    });
                }
            }
        });
    }
   }

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
        let typeThird = $('#filter_type_third').val();
        let typePerson = $('#filter_type_person').val();
        let status = $('#filterStatus').val();
        let startDate = $('#startDate').val(); 
        let endDate = $('#endDate').val();
    
        $.ajax({
        url: "{{route('person.fetch')}}",
        type: 'GET',
        data: {
            type_third: typeThird,
            type_person: typePerson,
            status: status,
        },
        success: function(response){
            let tableBody = '';
            $.each(response, function(index, customer){
                let createdAt = dayjs(customer.created_at).format('DD/MM/YYYY h:mm A');
                let updatedAt = dayjs(customer.updated_at).format('DD/MM/YYYY h:mm A');
                let statusText = customer.status == 1 ? 'Inactivo' : 'Activo';
              
                let toggleStatusText = customer.status == 1 ? 'Activar' : 'Desactivar';
                let toggleIcon = customer.status == 1 ? 'fa-toggle-on' : 'fa-toggle-off';

                tableBody += `<tr>
                                <td>${index + 1}</td>
                                 <td>${customer.type_third ? customer.type_third.type_third : 'N/A'}</td>
                               
                                <td>${customer.identification_type ? customer.identification_type.identification_name : 'N/A'}</td>
                               
                                <td>${customer.identification_number}</td>
                                <td>${customer.dv}</td>
                                <td>${customer.company_name}</td>
                                <td>${customer.name_trade}</td>
                                <td>${customer.first_name} ${customer.second_name} ${customer.last_name} ${customer.second_last_name}</td>
                              
                                <td>${customer.type_regimen ? customer.type_regimen.regimen_name : 'N/A'}</td>
                                <td>${customer.type_liability ? customer.type_liability.liability_name : 'N/A'}</td>
                                <td>${customer.ciiu_code ? customer.ciiu_code : 'N/A'}</td>
                                <td>${customer.great_taxpayer ? 'Sí' : 'No'}</td>
                                <td>${customer.self_withholder ? 'Sí' : 'No'}</td>
                                <td>${customer.ica_activity ? customer.ica_activity : 'N/A'}</td>
                                <td>${customer.ica_rate ? formatCurrency(customer.ica_rate) : 'N/A'}</td>
                                <td>${customer.commercial_registry ? customer.commercial_registry : 'N/A'}</td>
                                <td>${customer.registration_date ? dayjs(customer.registration_date).format('DD/MM/YYYY') : 'N/A'}</td>
                                <td>${customer.countries ? customer.countries.country_name : 'N/A'}</td>
                                <td>${customer.departments ? customer.departments.name_department : 'N/A'}</td>
                                <td>${customer.cities ? customer.cities.city_name : 'N/A'}</td>
                                <td>${customer.address}</td>
                                <td>${customer.phone}</td>
                                <td>${customer.email}</td>
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
  
    // Agregar el evento change para el filtro de tipo de tercero
    $('#filter_type_third').change(function() {
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
                url: "{{ url('admin/person/toggle-status') }}/" + customerId,
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
                    console.error('Error al cambiar el estado del tercero: ', error);
                }
            });
        }

        function handleView(e)
        {
            e.preventDefault(); 
            const customerId = $(this).data('id'); 
            window.location.href = "{{ url('admin/person') }}/" + customerId;
        }



        // edit
        function handleEdit(e) {
    e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
    let customerId = $(this).data('id');
    $.ajax({
        url: "{{ url('admin/person/edit') }}/" + customerId,
        type: 'GET',
        success: function(customer) { 
            // Establecer los valores en los campos del modal
          
            $('#identification_type_id').val(customer.identification_type_id);
            $('#identification_number').val(customer.identification_number);
            $('#dv').val(customer.dv);
            
            $('#name').val(customer.name);
            $('#last_name').val(customer.last_name);
            $('#type_person_id').val(customer.type_person_id);
            $('#type_liability_id').val(customer.type_liability_id);
            $('#type_regimen_id').val(customer.type_regimen_id);
            $('#type_third_id').val(customer.type_third_id);
            $('#ciiu_code').val(customer.ciiu_code);
            $('#great_taxpayer').val(customer.great_taxpayer);
            $('#self_withholder').val(customer.self_withholder);
            $('#ica_activity').val(customer.ica_activity);
            $('#ica_rate').val(customer.ica_rate);
            $('#commercial_registry').val(customer.commercial_registry);
            $('#registration_date').val(customer.registration_date);
            
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
                    url: "{{ url('admin/person/update') }}/" + customerId,
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
                        url: "{{ url('admin/person/delete') }}/" + customerId,
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
            $.ajax({
                url: "{{route('person.store')}}",
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


                                        
   