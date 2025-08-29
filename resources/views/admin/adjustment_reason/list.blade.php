@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Motivos de Ajuste</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Motivos de Ajuste
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
                                <h3 class="card-title">Listado de Motivos de Ajuste</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addMeasureModal">
                                            Agregar Medida
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="category-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tipo Ajuste</th>
                                                <th>Codigo</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
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
    <div class="modal fade" id="addMeasureModal" tabindex="-1" aria-labelledby="addMeasureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMeasureModalLabel">Agregar Motivo de Ajuste</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMeasureForm">
                        {{ @csrf_field() }}
                        <input type="hidden" name="company_id" id="company_id" value="{{ Auth::user()->company_id }}">
                        <div class="mb-3">
                            <label for="code" class="form-label"><b>Tipo Ajuste</b></label>
                            <select name="adjustment_type_id" id="adjustment_type_id" class="form-control">
                                <option value="">Seleccione un tipo de ajuste</option>
                                @foreach ($adjustment_types as $adjustment_type)
                                    <option value="{{ $adjustment_type->id }}">{{ $adjustment_type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reason_code" class="form-label"><b>Codigo</b></label>
                            <input type="text" class="form-control" id="reason_code" placeholder="Codigo" name="reason_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="reason_name" class="form-label"><b>Nombre</b></label>
                            <input type="text" class="form-control" id="reason_name" placeholder="Nombre" name="reason_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label"><b>Descripción</b></label>
                            <textarea class="form-control" id="description" placeholder="Descripción" name="description" rows="3"></textarea>
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
            fectMeasures();
            
            function fectMeasures(){
                $.ajax({
                    url: "{{url('admin/adjustment_reason/data')}}",
                    type: 'GET',
                    success: function(response){
                        let tableBody='';
                        $.each(response, function(index,measure){
                            let createdAt = dayjs(measure.created_at).format('DD/MM/YYYY h:mm A');
                            let updatedAt = dayjs(measure.updated_at).format('DD/MM/YYYY h:mm A');
                            tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${measure.adjustment_types.type_name}</td>
                                        <td>${measure.reason_code}</td>
                                        <td>${measure.reason_name}</td>
                                        <td>${measure.description}</td>
                                        <td>${measure.status == 1 ? 'Activo' : 'Inactivo'}</td>
                                        <td>${createdAt}</td>
                                       <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${measure.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${measure.id}"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                     
                                       
                                    </tr>`;
                        });
                        $('#category-table tbody').html(tableBody);
                        $('.edit-btn').on('click', handleEdit);
                        $('.delete-btn').on('click', handleDelete);
                    },
                    error: function(xhr, status, error){
                        console.error('Error al leer las categorias: ', error);
                    }
        
                });
            }
            // edit
         
            function handleEdit(e) {
                 e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
                let measureId = $(this).data('id');
                 $.ajax({
                     url: "{{ url('admin/adjustment_reason/edit') }}/" + measureId,
                  type: 'GET', success: function(measure)
                   { // Establecer los valores en los campos del modal
                    $('#adjustment_type_id').val(measure.adjustment_type_id);
                     $('#reason_code').val(measure.reason_code);
                      $('#reason_name').val(measure.reason_name); 
                      $('#description').val(measure.description); 
                      $('#addMeasureModal').modal('show'); // Manejar el envío del formulario de edición
                       $('#addMeasureForm').off('submit').on('submit', function(e) {
                         e.preventDefault(); // Prevenir el envío del formulario 
                         const formData = $(this).serialize();
                          $.ajax({ url: "{{ url('admin/adjustment_reason/update') }}/" + measureId, 
                          type: 'POST', 
                          data: formData,
                           success: function(response)
                            { $('#addMeasureModal').modal('hide');
                             fectMeasures(); 
                             $('#addMeasureForm')[0].reset(); 
                             $('.flashMessage') .text(response.success) .fadeIn() .delay(3000) .fadeOut();
                              setTimeout(function() { location.reload(); }, 2000); },
                               error: function(xhr, status, error) {
                                 console.error('Error al actualizar la medida: ', error);
                                 } });
                                 }); 
                                }, error: function(xhr, status, error) {
                                     console.error('Error al editar la medida: ', error);
                                     } 
                                    });
            }
            
            // delete
            function handleDelete(e) {
    e.preventDefault();
    const measureId = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará permanentemente la Medida.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/adjustment_reason/delete') }}/" + measureId,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    fectMeasures();
                    Swal.fire({
                        title: 'Eliminado!',
                        text: 'El motivo de ajuste ha sido eliminado.',
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
                    console.error('Error al eliminar la medida: ', error);
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
    $('#addMeasureForm').on('submit', function (e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ url('admin/adjustment_reason/store') }}",
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addMeasureModal').modal('hide');
                $('#addMeasureForm')[0].reset();
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
                console.error('Error al agregar la medida: ', error);
            }
        });
    });
});

   </script>

@endsection


                                        
   