@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Contactos</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Contactos
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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Buscar 
                                </h3>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header"> <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Buscar Contacto
                                                </button> </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6"> <label for="filterTypeContact" class="form-label"><b>Filtrar por Tipo de Contacto</b></label>
                                                            <select id="filterTypeContact" class="form-control">
                                                                <option value="">Todos</option> <option value="Customer">Cliente</option>
                                                                <option value="Supplier">Proveedor</option> 
                                                                </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6"> <label for="filterStatus" class="form-label"><b>Filtrar por Estado</b>
                                                    </label> <select id="filterStatus" class="form-control">
                                                        <option value="">Todos</option> 
                                                        <option value="1">Inactivo</option> 
                                                        <option value="0">Activo</option> </select> 
                                                        </div>
                                                       
                                                </div>
                                             </div>
                                    </div>
                                </div>
                                   
                                </div>
                            </form>
                        </div> <br>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Contactos</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addContactModal">
                                            Agregar Contacto
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table id="contact-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                 <th>Tipo Contacto</th>
                                                 <th>Tipo Identificación</th>
                                                 <th>Número</th>
                                                <th>Empresa</th>
                                                <th>Nombre Contacto</th>
                                                <th>Apellidos</th>
                                            
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
    <div class="modal fade" id="addContactModal" aria-labelledby="addContactModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContactModalLabel">Agregar Contacto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addContactForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type_contact" class="form-label"><b>Tipo de Contacto</b></label>
                                    <select name="type_contact" id="type_contact" class="form-control">
                                        <option value="Customer">Cliente</option>
                                        <option value="Supplier">Proveedor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tipo Identificación</label>
                                     <select name="identification_type_id" id="identification_type_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($identification_type as $key =>$item)
                                       <option value="{{$key }}">{{$item}}</option>
                                           
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="identification_number" class="form-label"><b>Número de Identificación</b></label>
                                    <input type="text" class="form-control" id="identification_number" name="identification_number" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label"><b>Razón Social</b></label>
                                    <input type="text" class="form-control" id="company_name" name="company_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_name" class="form-label"><b>Nombre del Contacto</b></label>
                                    <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_last_name" class="form-label"><b>Apellido del Contacto</b></label>
                                    <input type="text" class="form-control" id="contact_last_name" name="contact_last_name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type_person" class="form-label"><b>Tipo de Persona</b></label>
                                    <select name="type_person" id="type_person" class="form-control">
                                        <option value="legal_entity">Persona Jurídica</option>
                                        <option value="natural_person">Persona Natural</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tax_liability" class="form-label"><b>Responsabilidad Tributaria</b></label>
                                    <select name="tax_liability" id="tax_liability" class="form-control">
                                        <option value="vat_responsible">Responsable de IVA</option>
                                        <option value="not_liable_for_vat">No Responsable de IVA</option>
                                    </select>
                                </div>
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="address" class="form-label"><b>Dirección</b></label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone" class="form-label"><b>Teléfono</b></label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email" class="form-label"><b>Email</b></label>
                                    <input type="email" class="form-control" id="email" name="email">
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
    $(document).ready(function(){
        fechtContact();
        
        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
        }

        function fechtContact() {
    let typeContact = $('#filterTypeContact').val();
    let status = $('#filterStatus').val();
    let startDate = $('#startDate').val(); 
    let endDate = $('#endDate').val();
    
    $.ajax({
        url: "{{route('contact.fetch')}}",
        type: 'GET',
        data: {
            type_contact: typeContact,
            status: status,
            start_date: startDate, end_date: endDate    
        },
        success: function(response){
            let tableBody = '';
            $.each(response, function(index, contacts){
                let createdAt = dayjs(contacts.created_at).format('DD/MM/YYYY h:mm A');
                let updatedAt = dayjs(contacts.updated_at).format('DD/MM/YYYY h:mm A');
                let statusText = contacts.status == 1 ? 'Inactivo' : 'Activo';
                let type_contact = contacts.type_contact == 'Customer' ? 'Cliente' : 'Proveedor';
                let toggleStatusText = contacts.status == 1 ? 'Activar' : 'Desactivar';
                let toggleIcon = contacts.status == 1 ? 'fa-toggle-on' : 'fa-toggle-off';

                tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${type_contact}</td>
                                <td>${contacts.identification_type ? contacts.identification_type.identification_name : 'N/A'}</td>
                                <td>${contacts.identification_number}</td>
                                <td>${contacts.company_name}</td>
                                <td>${contacts.contact_name}</td>
                                <td>${contacts.contact_last_name}</td>
                                <td>${contacts.departments ? contacts.departments.name_department : 'N/A'}</td>
                                <td>${contacts.cities ? contacts.cities.city_name : 'N/A'}</td>
                                <td>${contacts.address}</td>
                                <td>${contacts.phone}</td>
                                <td>${contacts.email}</td>
                                <td>${statusText}</td>
                                <td>${createdAt}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${contacts.id}"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${contacts.id}"><i class="fa-solid fa-trash"></i></button>
                                    <button class="btn btn-secondary btn-sm toggle-status-btn" data-id="${contacts.id}" data-status="${contacts.status}"><i class="fa ${toggleIcon}"></i> ${toggleStatusText}</button>
                                    <button class="btn btn-info btn-sm view" data-id="${contacts.id}"><i class="fa-regular fa-eye"></i></button>
                                </td>
                             </tr>`;
            });
            $('#contact-table tbody').html(tableBody);
            $('.edit-btn').on('click', handleEdit);
            $('.delete-btn').on('click', handleDelete);
            $('.view').on('click', handleView);
            $('.toggle-status-btn').on('click', handleToggleStatus);
            $('#contact-table').DataTable();
        },
        error: function(xhr, status, error){
            console.error('Error al leer los contactos: ', error);
        }
    });
}

$(document).ready(function() {
    fechtContact();

    $('#filterTypeContact, #filterStatus').change(function() {
        fechtContact();
    });
});

        function handleToggleStatus(e) {
            e.preventDefault();
            const button = $(this);
            const contactId = button.data('id');
            const currentStatus = button.data('status');
            const newStatus = currentStatus == 1 ? 0 : 1;

            $.ajax({
                url: "{{ url('admin/contact/toggle-status') }}/" + contactId,
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
                    fechtContact(); // Refrescar la lista de ciudades
                },
                error: function(xhr, status, error) {
                    console.error('Error al cambiar el estado de la ciudad: ', error);
                }
            });
        }

        function handleView(e)
        {
            e.preventDefault(); 
            const contactId = $(this).data('id'); 
            window.location.href = "{{ url('admin/contact') }}/" + contactId;
        }



        // edit
        function handleEdit(e) {
    e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
    let contactId = $(this).data('id');
    $.ajax({
        url: "{{ url('admin/contact/edit') }}/" + contactId,
        type: 'GET',
        success: function(contact) { 
            // Establecer los valores en los campos del modal
            $('#contact').val(contact.type_contact);
            $('#identification_type_id').val(contact.identification_type_id);
            $('#identification_number').val(contact.identification_number);
            $('#company_name').val(contact.company_name);
            $('#contact_name').val(contact.contact_name);
            $('#contact_last_name').val(contact.contact_last_name);
            $('#type_person').val(contact.type_person);
            $('#tax_liability').val(contact.tax_liability);
            $('#department_id').val(contact.department_id);
            $('#city_id').val(contact.city_id);
            $('#address').val(contact.address);
            $('#phone').val(contact.phone);
           $('#email').val(contact.email);
            
                       
            $('#addContactModal').modal('show'); 
            
            // Manejar el envío del formulario de edición
            $('#addContactForm').off('submit').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario 
                const formData = $(this).serialize();
                $.ajax({ 
                    url: "{{ url('admin/contact/update') }}/" + contactId,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addContactModal').modal('hide');
                        fechtContact(); // Actualiza la lista de productos
                        $('#addContactForm')[0].reset();
                        $('.flashMessage')
                            .text(response.success)
                            .fadeIn()
                            .delay(3000)
                            .fadeOut();
                        setTimeout(function() { location.reload(); }, 2000);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al actualizar el contacto: ', error);
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
            const contactId = $(this).data('id');

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
                        url: "{{ url('admin/contact/delete') }}/" + contactId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fechtContact();
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
        $('#addContactForm').on('submit', function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{route('contact.store')}}",
                type: 'POST',
                data: formData,
                success: function(response){
                    $('#addContactModal').modal('hide');
                    $('#addContactForm')[0].reset();
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
                    console.error('Error al agregar el contacto: ', error);
                }
            });
        });

      

      
    });
</script>


@endsection


                                        
   