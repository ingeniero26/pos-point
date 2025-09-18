@extends('layouts.app')

    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Ciudades</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Ciudades
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
                                <h3 class="card-title">Listado de Ciudades</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addCityModal">
                                            Agregar Ciudad
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
                                                <th>Código Dane</th>
                                                 <th>Departamento</th>
                                                <th>Ciudad</th>
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
    <div class="modal fade" id="addCityModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCityModalLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCityForm" >
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dane_code" class="form-label"><b>Código Dane</b></label>
                                    <input type="text" class="form-control" id="dane_code" name="dane_code" required>
                                </div>
                            </div>
                         
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Departamento</label>
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
                                    <label for="" class="form-label">Ciudad </label>
                                    <input type="text" id="city_name" name="city_name" class="form-control">
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
    $(document).ready(function(){
        fechtCities();
        
  
        function fechtCities(){
            $.ajax({
                url: "{{route('city.fetch')}}",
                type: 'GET',
                success: function(response){
                    let tableBody = '';
                    $.each(response, function(index, citys){
                        let createdAt = dayjs(citys.created_at).format('DD/MM/YYYY h:mm A');
                        let updatedAt = dayjs(citys.updated_at).format('DD/MM/YYYY h:mm A');
                        let statusText = citys.status == 1 ? 'Inactivo' : 'Activo';
                        let toggleStatusText = citys.status == 1 ? 'Activar' : 'Desactivar';
                        let toggleIcon = citys.status == 1 ? 'fa-toggle-on' : 'fa-toggle-off';
                        
                        tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>${citys.dane_code}</td>
                                        <td>${ citys.departments ? citys.departments.name_department : 'N/A'}</td>
                                        <td>${citys.city_name}</td>
                                    
                                   
                                        <td>${statusText}</td>
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                       <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${citys.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${citys.id}"><i class="fa-solid fa-trash"></i></button>
                                            <button class="btn btn-secondary btn-sm toggle-status-btn" data-id="${citys.id}" data-status="${citys.status}"><i class="fa ${toggleIcon}"></i> ${toggleStatusText}</button>
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
                url: "{{ url('admin/city/toggle-status') }}/" + cityId,
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
                    fechtCities(); // Refrescar la lista de ciudades
                },
                error: function(xhr, status, error) {
                    console.error('Error al cambiar el estado de la ciudad: ', error);
                }
            });
        }


        // edit
        function handleEdit(e) {
    e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace o botón 
    let cityId = $(this).data('id');
    $.ajax({
        url: "{{ url('admin/city/edit') }}/" + cityId,
        type: 'GET',
        success: function(city) { 
            // Establecer los valores en los campos del modal
            $('#addCityModalLabel').text('Editar Ciudad');

            $('#dane_code').val(city.dane_code);
     
            $('#department_id').val(city.department_id);
   
            $('#city_name').val(city.city_name);
            
            $('#addCityModal').modal('show'); 
            
            
            // Manejar el envío del formulario de edición
            $('#addCityForm').off('submit').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario 
                const formData = $(this).serialize();
                $.ajax({ 
                    url: "{{ url('admin/city/update') }}/" + cityId,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addCityModal').modal('hide');
                        fechtCities(); // Actualiza la lista de productos
                        $('#addCityForm')[0].reset();
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
            const cityId = $(this).data('id');

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
                        url: "{{ url('admin/city/delete') }}/" + cityId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fechtCities();
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
        $('#addCityForm').on('submit', function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{route('city.store')}}",
                type: 'POST',
                data: formData,
                success: function(response){
                    $('#addCityModal').modal('hide');
                    $('#addCityForm')[0].reset();
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
                    console.error('Error al agregar el producto: ', error);
                }
            });
        });


    });
</script>


@endsection


                                        
   