@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Impuestos</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Impuestos
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
                                <h3 class="card-title">Listado de Impuestos</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addTaxesModal">
                                            Agregar Impuesto
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="taxes-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tipo Impuesto</th>
                                                <th>Tarifa</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
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
    <div class="modal fade" id="addTaxesModal" tabindex="-1" aria-labelledby="addTaxesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaxesModalLabel">Agregar Bodega</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTaxesForm">
                        {{ @csrf_field() }}
                        <div class="mb-3">
                            <label for="tax_type" class="form-label"><b>Tipo Impuesto</b></label>
                            <select name="tax_type_id" id="tax_type_id" class="form-control">
                                   <option value="">Seleccione...</option>
                                    @foreach($taxesType as $taxType)
                                    <option value="{{ $taxType->id }}">{{ $taxType->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Rate" class="form-label"><b>Tarifa</b></label>
                            <input type="text" class="form-control" id="rate" name="rate" required>
                        </div>
                        <div class="mb-3">
                            <label for="taxName" class="form-label"><b>Nombre</b></label>
                            <input type="text" class="form-control" id="tax_name" name="tax_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label"><b>Descripciòn</b></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
            fectTaxes();
            
            function fectTaxes(){
                $.ajax({
                    url: "{{url('admin/tax/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,tax){
                            let createdAt = dayjs(tax.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(tax.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${tax.taxes_type.name}</td>
                                        <td>${tax.rate}</td>
                                        <td>${tax.tax_name}</td>
                                        <td>${tax.description}</td>
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${tax.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${tax.id}"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                      
                                     
                                       
                                    </tr>`;
                        });
                        $('#taxes-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                        $('#taxes-table').DataTable();
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer las bodegas: ', error);
                    }
        
                });
            }
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let taxId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/tax/edit') }}/" + taxId,
                  type: 'GET',
                   success: function(tax)
                   { // Establecer los valores en los campos del modal
                     $('#tax_type_id').val(tax.tax_type_id);
                     $('#rate').val(tax.rate);
                     $('#tax_name').val(tax.tax_name);
                      $('#description').val(tax.description); 
                      $('#addTaxesModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addTaxesForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/tax/update') }}/" + taxId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addTaxesModal').modal('hide');
                            fectTaxes();
                              $('#addTaxesForm')[0].reset(); 
                             $('.flashMessage') 
                             .text(response.success)
                              .fadeIn()
                               .delay(3000) 
                               .fadeOut();
                              setTimeout(function() { location.reload(); }, 2000);
                             },
                               error: function(xhr, status, error) {
                                 console.error('Error al actualizar el impuesto: ', error);
                                 } });
                                 }); 
                                }, error: function(xhr, status, error) {
                                     console.error('Error al editar el impuesto: ', error);
                                     } 
                                    });
            }
            
            // delete
            function handleDelete(e) {
            e.preventDefault();
            const taxId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente el impuesto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/tax/delete') }}/" + taxId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fectTaxes();
                            Swal.fire({
                                title: 'Eliminado!',
                                text: 'El impuesto ha sido eliminado.',
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

            // function handleDelete(e) {
            //     e.preventDefault();
            //     const categoryId = $(this).data('id');
            //     if(confirm('Esta seguro de eliminar este registro?'))

            //     {
            //         $.ajax({
            //             url: "{{ url('admin/category/delete') }}/" + categoryId,
            //             type: 'DELETE',
            //             data: {
            //                 _token: "{{ csrf_token() }}",
            //             },
            //             success: function(response){
            //                 fectCategories();
            //                 $('.flashMessage')
            //                 .text(response.success)
            //                 .fadeIn()
            //                 .delay(3000)
            //                 .fadeOut();
            //                 setTimeout(function(){
            //                     location.reload();
            //                 }, 2000);
                        
            //             },
            //         })
            //     }
            // }
        });
   </script>
   <script type="text/javascript">
   $(document).ready(function(){
    $('#addTaxesForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/tax/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addTaxesModal').modal('hide');
                $('#addTaxesForm')[0].reset();
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


                                        
   