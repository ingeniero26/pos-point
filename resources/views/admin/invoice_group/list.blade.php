@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Grupo de Inventario Items</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Grupo de Inventario Items
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
                                <h3 class="card-title">Listado de Grupo de Inventario Items</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                                            Agregar
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="warehouse-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Impuesto</th>
                                                <th>Tarifa</th>
                                                <th>Retefuente</th>
                                                <th>Cuenta(PUC)</th>
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
    <div class="modal fade" id="addWarehouseModal" tabindex="-1" aria-labelledby="addWarehouseModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWarehouseModalLabel">Agregar Grupo de Inventario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addWarehouseForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="warehouseName" class="form-label"><b>Código Dian</b></label>
                            <input type="text" class="form-control" id="dian_code" name="dian_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label"><b>Nombre</b></label>
                            <input type="text" class="form-control" id="name" name="name" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label"><b>Impuesto</b></label>
                            <input type="text" class="form-control" id="taxes" name="taxes" ></input>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label"><b>Tarifa</b></label>
                            <input type="text" class="form-control" id="vat_rate" name="vat_rate" ></input>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label"><b>Retefuente</b></label>
                            <input type="text" class="form-control" id="ica_rete" name="ica_rete" ></input>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label"><b>Cuenta(PUC)</b></label>
                            <input type="text" class="form-control" id="account" name="account" ></input>
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
            fectWarehouse();
            
            function fectWarehouse(){
                $.ajax({
                    url: "{{url('admin/invoice_group/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,invoiceGroups){
                            let createdAt = dayjs(invoiceGroups.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(invoiceGroups.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${invoiceGroups.dian_code}</td>
                                        <td>${invoiceGroups.name}</td>
                                        <td>${invoiceGroups.taxes}</td>
                                        <td>${invoiceGroups.vat_rate}</td>
                                        <td>${invoiceGroups.ica_rete}</td>
                                        <td>${invoiceGroups.account}</td>
                                        <td>${invoiceGroups.status ? 'Activo' : 'Inactivo'}</td>
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${invoiceGroups.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${invoiceGroups.id}"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                      
                                     
                                       
                                    </tr>`;
                        });
                        $('#warehouse-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                        // datatable initialization
                       $('#warehouse-table').DataTable();
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer los grupo de inventario: ', error);
                    }
        
                });
            }
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let warehouseId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/invoice_group/edit') }}/" + warehouseId,
                  type: 'GET', success: function(invoiceGroup)
                   { // Establecer los valores en los campos del modal
                     $('#dian_code').val(invoiceGroup.dian_code);
                      $('#name').val(invoiceGroup.name); 
                      $('#taxes').val(invoiceGroup.taxes);
                      $('#vat_rate').val(invoiceGroup.vat_rate);
                      $('#ica_rete').val(invoiceGroup.ica_rete);
                      $('#account').val(invoiceGroup.account);
                      $('#addWarehouseModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addWarehouseForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/invoice_group/update') }}/" + warehouseId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addWarehouseModal').modal('hide');
                             fectWarehouse();
                              $('#addWarehouseForm')[0].reset(); 
                             $('.flashMessage') 
                             .text(response.success)
                              .fadeIn()
                               .delay(3000) 
                               .fadeOut();
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
    const warehouseId = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará permanentemente el registro",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/invoice_group/delete') }}/" + warehouseId,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    fectWarehouse();
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
                    console.error('Error al eliminar la categoría: ', error);
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
    $('#addWarehouseForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/invoice_group/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addWarehouseModal').modal('hide');
                $('#addWarehouseForm')[0].reset();
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


                                        
   