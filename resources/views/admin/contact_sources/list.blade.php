@extends('layouts.app')

    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Fuentes de  Contactos</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Fuentes de Contactos 
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
                                <h3 class="card-title">Listado de Fuentes de Contactos</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addAccountBankModal">
                                            Agregar Fuente Contacto
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="city-table" class="table table-striped table-bordered">
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
    <div class="modal fade" id="addAccountBankModal" tabindex="-1" aria-labelledby="addAccountBankModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountBankModalLabel">Agregar Tipo Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAccountBankForm" >
                        @csrf
                      
                            <div class="col-md-6">
                                <label for="">Fuente Contacto</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                         
                            <div class="col-md-12">
                                <label for="">Descripción</label>
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>
                         
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label"><b>Activo</b></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
            
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
   
       

    fechtAccountBank();
        
  
        function fechtAccountBank(){
            $.ajax({
                url: "{{route('admin.contact_source.fetch')}}",
                type: 'GET',
                success: function(response){
                    let tableBody = '';
                    $.each(response, function(index, account_bank){
                        let createdAt = dayjs(account_bank.created_at).format('DD/MM/YYYY h:mm A');
                        let updatedAt = dayjs(account_bank.updated_at).format('DD/MM/YYYY h:mm A');
                        let statusText = account_bank.status == 1 ? 'Activo' : 'Inactivo';
                        let toggleStatusText = account_bank.status == 1 ? 'Desactivar' : 'Activar';
                        let toggleIcon = account_bank.status == 1 ? 'fa-toggle-on' : 'fa-toggle-off';
                        
                        tableBody += `<tr>
                                        <td>${index + 1}</td>
                                     
                                        <td>${account_bank.name}</td>
                                        
                                        <td>${account_bank.description}</td>                                         
                                        <td>${statusText}</td>
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                       <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${account_bank.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${account_bank.id}"><i class="fa-solid fa-trash"></i></button>
                                            <button class="btn btn-secondary btn-sm toggle-status-btn" data-id="${account_bank.id}" data-status="${account_bank.status}"><i class="fa ${toggleIcon}"></i> ${toggleStatusText}</button>
                                        </td>
                                     </tr>`;
                    });
                    $('#city-table tbody').html(tableBody);
                    $('.edit-btn').on('click', handleEdit);
                    $('.delete-btn').on('click', handleDelete);
                    $('.toggle-status-btn').on('click', handleToggleStatus);
                    $('#city-table').DataTable();
                },
                error: function(xhr, status, error){
                    console.error('Error al leer los registros: ', error);
                }
            });
        }

        function handleToggleStatus(e) {
            e.preventDefault();
            const button = $(this);
            const cityId = button.data('id');
            const currentStatus = button.data('status');
            const newStatus = currentStatus == 1 ? 0 : 1;

            $.ajax({
                url: "{{ url('admin/contact_sources/toggle-status') }}/" + cityId,
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
                    fechtAccountBank(); // Refrescar la lista de ciudades
                },
                error: function(xhr, status, error) {
                    console.error('Error al cambiar el estado del registro: ', error);
                }
            });
        }


        // edit
        function handleEdit(e) {
               e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
         let account_bankId = $(this).data('id');
         $.ajax({
        url: "{{ url('admin/contact_sources/edit') }}/" + account_bankId,
           type: 'GET',
        success: function(city) { 
            // Establecer los valores en los campos del modal     
            $('#name').val(city.name);
            $('#description').val(city.description);
            $('#colour').val(city.colour);
            $('#status').val(city.status);
            
            $('#addAccountBankModal').modal('show'); 
            
            // Manejar el envío del formulario de edición
            $('#addAccountBankForm').off('submit').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario 
                const formData = $(this).serialize();
                $.ajax({ 
                    url: "{{ url('admin/contact_sources/update') }}/" + account_bankId,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addAccountBankModal').modal('hide');
                        fechtAccountBank(); // Actualiza la lista de productos
                        $('#addAccountBankForm')[0].reset();
                        $('.flashMessage')
                            .text(response.success)
                            .fadeIn()
                            .delay(3000)
                            .fadeOut();
                        setTimeout(function() { location.reload(); }, 2000);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al actualizar el registro: ', error);
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al editar el producto: ', error);
        }
    });
}
 function handleDelete(e) {
        e.preventDefault();
        const colorId = $(this).data('id');

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
                    url: "{{ url('admin/contact_sources/delete') }}/" + colorId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        fectColors();
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'el registro ha sido eliminada.',
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
                         fechtAccountBank();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al eliminar el registro: ', error);
                    }
                });
            }
        });
}
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#addAccountBankForm').on('submit', function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{route('admin.contact_source.store')}}",
                type: 'POST',
                data: formData,
                success: function(response){
                    $('#addAccountBankModal').modal('hide');
                    $('#addAccountBankForm')[0].reset();
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


                                        
   