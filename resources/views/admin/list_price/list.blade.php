@extends('layouts.app')

    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Cuentas Bancarias</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Cuentas 
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
                                <h3 class="card-title">Listado de Precios</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addAccountBankModal">
                                            Agregar Lista de Precios
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
                                                <th>Descripcion</th>
                                                <th>Tipo</th>
                                                <th>Moneda</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin</th>
                                                                                               
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
                    <h5 class="modal-title" id="addAccountBankModalLabel">Agregar Lista de Precios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAccountBankForm" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nombre</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Descripción</label>
                                    <textarea id="description" name="description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tipo</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="value">Valor</option>
                                        <option value="percentage">Porcentaje</option>
                                    </select>
                                </div>
                            </div>                          
                            

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Moneda</label>
                                     <select name="currency_id" id="currency_id" class="form-control">
                                        <option value="">Seleccione</option>
                                       @foreach ($currencies as $key =>$item)
                                       <option value="{{ $key }}" {{ $key == '170' ? 'selected' : '' }}>{{ $item }}</option>
                                           
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Fecha Inicio</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Fecha Fin</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control">
                                </div>
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
    function duplicateAccountNumber(input){
            var number = input.value;
            if (number) {
                $.ajax({
                    url: '{{ url('admin/account_bank/check-number') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        number: number
                    },
                    success: function(response) {
                        if (response.exists) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'El Numero,  ya está en uso.'
                            }).then(() => {
                                input.value = '';
                            });
                        }
                    }
                });
            }
        }
  
    $(document).ready(function(){
        // validar duplicado de cuenta 
       

    fechtAccountBank();
        
  
        function fechtAccountBank(){
            $.ajax({
                url: "{{route('admin.list_price.data')}}",
                type: 'GET',
                success: function(response){
                    let tableBody = '';
                    $.each(response, function(index, account_bank){
                        let createdAt = dayjs(account_bank.created_at).format('DD/MM/YYYY h:mm A');
                        let updatedAt = dayjs(account_bank.updated_at).format('DD/MM/YYYY h:mm A');
                        let startDate = dayjs(account_bank.start_date).format('DD/MM/YYYY');
                        let endDate = dayjs(account_bank.end_date).format('DD/MM/YYYY');
                        let statusText = account_bank.status == 1 ? 'Activo' : 'Inactivo';
                        let toggleStatusText = account_bank.status == 1 ? 'Activar' : 'Desactivar';
                        let toggleIcon = account_bank.status == 1 ? 'fa-toggle-on' : 'fa-toggle-off';
                        
                        tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${account_bank.name}</td>
                                        <td>${account_bank.description}</td>
                                        <td>${account_bank.type}</td>
                                    
                                        <td>${account_bank.currency ? account_bank.currency.currency_name : 'N/A'}</td>
                                        <td>${startDate}</td>
                                        <td>${endDate}</td>
                                                                             
                                          
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
                url: "{{ url('admin/bank_account/toggle-status') }}/" + cityId,
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
                    console.error('Error al cambiar el estado de la ciudad: ', error);
                }
            });
        }


        // edit
        function handleEdit(e) {
               e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
         let account_bankId = $(this).data('id');
         $.ajax({
        url: "{{ url('admin/account_bank/edit') }}/" + account_bankId,
           type: 'GET',
        success: function(city) { 
            // Establecer los valores en los campos del modal     
            $('#bank_id').val(city.bank_id);
            $('#account_type_id').val(city.account_type_id);
            $('#currency_id').val(city.currency_id);
            $('#number').val(city.number);
            $('#amount').val(city.amount);
            $('#description').val(city.description);
            $('#status').val(city.status);
            
            $('#addAccountBankModal').modal('show'); 
            
            // Manejar el envío del formulario de edición
            $('#addAccountBankForm').off('submit').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario 
                const formData = $(this).serialize();
                $.ajax({ 
                    url: "{{ url('admin/account_bank/update') }}/" + account_bankId,
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
            const account_bankId = $(this).data('id');

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
                        url: "{{ url('admin/account_bank/delete') }}/" + account_bankId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fechtAccountBank();
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
        $('#addAccountBankForm').on('submit', function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{route('admin.list_price.store')}}",
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


                                        
   