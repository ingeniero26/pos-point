@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Categorias de Activos</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Categorias de Activos
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
                                <h3 class="card-title">Listado de Categorias de Activos</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addCostCenterModal">
                                            Agregar Categoria de Activo
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="entity_bank-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Método Depreciación</th>
                                                <th>Vida Util</th>
                                                <th>Tarifa</th>
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
    <div class="modal fade" id="addCostCenterModal" tabindex="-1" aria-labelledby="addCostCenterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCostCenterModalLabel">Agregar Categoria de Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCostCenterForm">
                        {{ @csrf_field() }}
                  
                        <div class="mb-3">
                            <label for="Rate" class="form-label"><b>Nombre</b></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="taxName" class="form-label"><b>Descripción</b></label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="taxName" class="form-label"><b>Método Depreciación</b></label>
                            <select name="depreciation_method" id="depreciation_method" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="straight_line">Linea Recta</option>
                                <option value="declining_balance">Saldo Disminuido</option>
                                <option value="units_of_production">Unidades de Producción</option>
                                <option value="sum_of_years_digits">Suma de Dígitos</option>
                                <option value="undefined">Indefinido</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="taxName" class="form-label"><b>Vida Util</b></label>
                            <input type="text" class="form-control" id="useful_life_years" name="useful_life_years">
                        </div>
                        <div class="mb-3">
                            <label for="taxName" class="form-label"><b>Tarifa</b></label>
                            <input type="text" class="form-control" id="depreciation_rate" name="depreciation_rate">
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
            fetchBankEntity();
            
            function fetchBankEntity() {
    $.ajax({
        url: "{{ url('admin/asset_category/data') }}",
        type: 'GET',
        success: function (response) {
            let tableBody = '';

            $.each(response, function (index, costCenters) {
                // Verificar si is_delete = 1 (opcional, si el backend ya filtra)
                if (costCenters.is_delete === 0) {
                    let createdAt = dayjs(costCenters.created_at).format('DD/MM/YYYY h:mm A');
                    let updatedAt = dayjs(costCenters.updated_at).format('DD/MM/YYYY h:mm A');
                    let depreciationMethod = '';
                    if(costCenters.depreciation_method == 'straight_line'){
                        depreciationMethod = 'Linea Recta';
                    }else if(costCenters.depreciation_method == 'Saldo Disminuido'){
                        depreciationMethod = 'Saldo Disminuido';
                    }else if(costCenters.depreciation_method == 'units_of_production'){
                        depreciationMethod = 'Unidades de Producción';
                    }else if(costCenters.depreciation_method == 'sum_of_years_digits'){
                        depreciationMethod = 'Suma de Dígitos';
                    }else if(costCenters.depreciation_method == 'undefined'){
                        depreciationMethod = 'Indefinido';
                    }
                    tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${costCenters.name}</td>
                                <td>${costCenters.description}</td>
                                <td>${depreciationMethod}</td>
                                <td>${costCenters.useful_life_years}</td>
                                <td>${costCenters.depreciation_rate}</td>
                                <td>${createdAt}</td>
                                <td>${updatedAt}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="${costCenters.id}"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${costCenters.id}"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>`;
                }
            });

            $('#entity_bank-table tbody').html(tableBody);
            $('.edit-btn').on('click', handleEdit);
            $('.delete-btn').on('click', handleDelete);
            $('#entity_bank-table').DataTable();
        },
        error: function (xhr, status, error) {
            console.error('Error al leer las categorias de activos: ', error);
        }
    });
}
       
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let cost_centerId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/asset_category/edit') }}/" + cost_centerId,
                  type: 'GET',
                   success: function(bank)
                   { // Establecer los valores en los campos del modal
                 
                     
                     $('#name').val(bank.name);
                      $('#description').val(bank.description); 
                      $('#depreciation_method').val(bank.depreciation_method);
                      $('#useful_life_years').val(bank.useful_life_years);
                      $('#depreciation_rate').val(bank.depreciation_rate);
                      $('#addCostCenterModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addCostCenterForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/asset_category/update') }}/" + cost_centerId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addCostCenterModal').modal('hide');
                            fetchBankEntity();
                              $('#addCostCenterForm')[0].reset(); 
                             $('.flashMessage') 
                             .text(response.success)
                              .fadeIn()
                               .delay(3000) 
                               .fadeOut();
                              setTimeout(function() { location.reload(); }, 2000);
                             },
                               error: function(xhr, status, error) {
                                 console.error('Error al actualizar el banco: ', error);
                                 } });
                                 }); 
                                }, error: function(xhr, status, error) {
                                     console.error('Error al editar el banco: ', error);
                                     } 
                                    });
            }
            
            // delete
            function handleDelete(e) {
            e.preventDefault();
            const cost_centerId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente la categoría.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/asset_category/delete') }}/" + cost_centerId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fetchBankEntity();
                            Swal.fire({
                                title: 'Eliminado!',
                                text: 'La categoría ha sido eliminada.',
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
    $('#addCostCenterForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/asset_category/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addCostCenterModal').modal('hide');
                $('#addCostCenterForm')[0].reset();
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


                                        
   