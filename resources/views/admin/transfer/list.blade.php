@extends('layouts.app')
  
@section('content')
<main class="app-main"> 
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Traslado entre Bodegas</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Traslado Productos
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="card-title">Listado de Traslados</h4>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <a href="{{url('admin/transfer/create')}}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Nuevo Traslado
                                    </a>&nbsp;
                                    <a href="{{url('admin/transfer/export_pdf')}}" class="btn btn-info">
                                        <i class="fas fa-plus"></i> PDF
                                    </a>
                                </div>
                              
                                
                            </div>
                        </div>
                        <div class="card-body">
                        
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="fecha_inicio">Fecha de Inicio</label>
                                    <input type="date" id="fecha_inicio" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_fin">Fecha de Fin</label>
                                    <input type="date" id="fecha_fin" class="form-control">
                                </div>
                                {{-- <div class="col-md-4">
                                    <label for="bodega">Bodega</label>
                                    <select id="bodega" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach ($warehouses as $bodega)
                                            <option value="{{ $bodega->id }}">{{ $bodega->warehouse_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div>

                                    <button id="filtrar" class="btn btn-primary mt-2">Filtrar</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="transfersTable">
                                    <thead>
                                        <tr>
                                             <th>ID</th>
                                             <th>Fecha</th>
                                             <th>Origen</th>
                                             <th>Destino</th>
                                             <th>Descripción</th>
                                             <th>Estado Traslado</th>
                                             <th>Detalles</th>
                                             <th>Acción</th>
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
<div class="modal fade" id="transferDetailsModal" tabindex="-1" role="dialog" aria-labelledby="transferDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transferDetailsModalLabel">Detalles del Traslado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
   $(document).ready(function() {
    $('#filtrar').click(function() {
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin = $('#fecha_fin').val();
        var bodegaId = $('#bodega').val();
            $.ajax({
                url: '{{route('admin.transfer.fetch')}}', // Ruta definida en Laravel
                method: 'GET',
                dataType: 'json',
                data: {
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin
                // bodega_id: bodegaId
            },
                success: function(data) {
                    var tableBody = $('#transfersTable tbody');
                    tableBody.empty(); // Limpiar el cuerpo de la tabla

                    $.each(data, function(index, transfer) {
                        // var details = transfer.transfer_detail.map(detail => {
                        //     return `${detail.product.product_name}: ${detail.quantity}`;
                        // }).join('<br>');

                        var row = `<tr>
                                    <td>${transfer.id}</td>
                                    <td>${transfer.transfer_date}</td>
                                    <td>${transfer.warehouse.warehouse_name}</td>
                                    <td>${transfer.warehouse_destination.warehouse_name}</td>
                                     <td>${transfer.description}</td>
                                     <td>${transfer.status_transfer.name}</td>
                                     <td><button class="btn btn-sm btn-primary show-details" data-transfer-id="${transfer.id}">Detalles</button></td>
                                     <td>
                                        <button class="btn btn-info print-pdf" data-transfer-id=" ${transfer.id }">
                                            Descargar PDF
                                        </button>
                                        </td>
                                      
                                   
                                   </tr>`;
                        tableBody.append(row);
                        //$('.print-pdf').on('click', handlePrintPdf);
                    });
                    $('#transfersTable').DataTable();
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', error);
                }
            });
          
        }); 
    }); 

    $(document).on('click', '.print-pdf', function() {
        const transferId = $(this).data('transfer-id'); // Obtener el ID del traslado

        window.open(`${transferId}/pdf`, '_blank'); // Abrir el PDF en una nueva ventana
    
    });



 
    
    $(document).on('click', '.show-details', function() {
            const transferId = $(this).data('transfer-id'); // Obtener el ID del traslado
            const button = $(this); // Referencia al botón clickeado

        // Deshabilitar el botón y mostrar un spinner
            button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Cargando...');

            // Realizar la solicitud AJAX
        $.ajax({
            url: `${transferId}/details`, // URL de la solicitud
            method: 'GET',
            dataType: 'json',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token para seguridad
        },
        success: function(response) {
            // Restaurar el botón
            button.prop('disabled', false).html('Detalles');

            // Verificar si la respuesta contiene datos
            if (response) {
                // Mostrar los detalles en un modal
                showDetailsModal(response);
                console.log(response)

            } else {
                alert('No se encontraron detalles para este traslado.');
            }
        },
        error: function(xhr) {
            // Restaurar el botón
            button.prop('disabled', false).html('Detalles');

            // Mostrar mensaje de error
            alert('Error al cargar los detalles del traslado');
            console.error('Error:', xhr.responseText);
        }
    });
    });
    function showDetailsModal(data) {
        // Crear el contenido del modal
        let modalContent = `
            <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel">Detalles del Traslado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>ID Traslado:</strong> ${data.id}</p>
                            <p><strong>Fecha:</strong> ${data.transfer_date}</p>
                            <p><strong>Desde:</strong> ${data.warehouse.warehouse_name}</p>
                            <p><strong>Hacia:</strong> ${data.warehouse_destination.warehouse_name}</p>
                            <p><strong>Estado:</strong> ${data.status_transfer.name}</p>
                            <h5>Detalles de Productos:</h5>
                            <ul>
        `;

        // Agregar los detalles de los productos
        if (Array.isArray(data.details) && data.details.length > 0) {
            data.details.forEach(detail => {
                modalContent += `
                    <li>
                        <strong>Producto:</strong> ${detail.item.product_name}, 
                        <strong>Cantidad:</strong> ${detail.quantity}
                    </li>
                `;
            });
        } else {
            modalContent += `<li>No hay detalles de productos disponibles.</li>`;
        }

        // Cerrar el contenido del modal
        modalContent += `
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Agregar el modal al cuerpo del documento
        $('body').append(modalContent);

        // Mostrar el modal
        $('#detailsModal').modal('show');

        // Eliminar el modal del DOM después de cerrarlo
        $('#detailsModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });
    }




</script>
@endsection