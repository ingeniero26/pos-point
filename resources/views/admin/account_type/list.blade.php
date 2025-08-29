@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tipo Cuentas Contables</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tipo Cuentas Contables
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
                                <h3 class="card-title">Listado de  Documentos Contables</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                       
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
                                                
                                                <th>Naturaleza</th>
                                                <th>Estado</th>
                                              
                                                 <th>Creado</th>
                                                 <th>Actualizado</th>
                                                
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
 
          
    @endsection
   @section('script')
   <script type="text/javascript">
        $(document).ready(function(){
            fetchBankEntity();
            
    function fetchBankEntity() {
             $.ajax({
        url: "{{ url('admin/accounting_type/data') }}",
        type: 'GET',
        success: function (response) {
            let tableBody = '';

            $.each(response, function (index, getDocumentTypes) {
                // Verificar si is_delete = 1 (opcional, si el backend ya filtra)
                if (getDocumentTypes.is_delete === 0) {
                    let createdAt = dayjs(getDocumentTypes.created_at).format('DD/MM/YYYY h:mm A');
                    let updatedAt = dayjs(getDocumentTypes.updated_at).format('DD/MM/YYYY h:mm A');
                    tableBody += `<tr>
                                <td>${index + 1}</td>
                               
                                <td>${getDocumentTypes.name}</td>
                                <td>${getDocumentTypes.nature}</td>
                                <td>${getDocumentTypes.is_active}</td>
                                <td>${createdAt}</td>
                                <td>${updatedAt}</td>
                              
                            </tr>`;
                }
            });

            $('#entity_bank-table tbody').html(tableBody);
            $('.edit-btn').on('click', handleEdit);
            $('.delete-btn').on('click', handleDelete);
            $('#entity_bank-table').DataTable();
        },
        error: function (xhr, status, error) {
            console.error('Error al leer las entidades bancarias: ', error);
        }
    });
}
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let account_document_typeId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/account_document_type/edit') }}/" + account_document_typeId,
                  type: 'GET',
                   success: function(bank)
                   { // Establecer los valores en los campos del modal
                 
                     
                     $('#code').val(bank.code);
                      $('#name').val(bank.name); 
                      $('#addAccountingDocumentModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addAccountingDocumentForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ 
                            url: "{{ url('admin/account_document_type/update') }}/" +account_document_typeId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addAccountingDocumentModal').modal('hide');
                            fetchBankEntity();
                              $('#addAccountingDocumentForm')[0].reset(); 
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
            const account_document_typeId = $(this).data('id');

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
                        url: "{{ url('admin/account_document_type/delete') }}/" + account_document_typeId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fetchBankEntity();
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

        
        });
   </script>
   <script type="text/javascript">
   $(document).ready(function(){
    $('#addAccountingDocumentForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/account_document_type/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addAccountingDocumentModal').modal('hide');
                $('#addAccountingDocumentForm')[0].reset();
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


                                        
   