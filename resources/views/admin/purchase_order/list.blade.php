@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Nota de Compra</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Nota de Compras
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content-body">
        <div class="containier-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Listado de Compras</h4>
                                   
                                </div>
                                <div class="col-md-6">
                                    <a href="{{url('admin/purchase_order/add')}}" class="btn btn-primary float-end">
                                    Nueva Nota
                                </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tb_purchases">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha Orden</th>
                                            <th>Fecha Espera</th>
                                            <th>Proveedor</th>
                                            <th>Prefijo</th>
                                            <th>Estado</th>
                                           
                                           
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                           <th>Total</th>
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
</main>

@endsection
@section('script')
<script>
    // listar las compras
    $(document).ready(function() {
        $.ajax({
                url: '{{route('admin.purchase_order.fetch')}}', // Ruta definida en Laravel
                method: 'GET',
                dataType: 'json',
                data: {
                    // Puedes agregar parámetros adicionales si es necesario
            },
                success: function(data) {
                    var tableBody = $('#tb_purchases tbody');
                    tableBody.empty(); // Limpiar el cuerpo de la tabla

                    $.each(data, function(index, purchaseOrders) {
                        // var details = transfer.transfer_detail.map(detail => {
                        //     return `${detail.product.product_name}: ${detail.quantity}`;
                        // }).join('<br>');

                        var row = `<tr>
                                    <td>${purchaseOrders.id}</td>
                                    <td>${purchaseOrders.order_date}</td>
                                    <td>${purchaseOrders.expected_date}</td>

                                    <td>${purchaseOrders.suppliers.company_name}</td>
                                    <td>${purchaseOrders.prefix}</td>
                                    <td>
                                    <select class="form-select form-select-sm state-select" data-purchase-id="${purchaseOrders.id}" data-current-state="${purchaseOrders.status_order.id}">
                                            <option value="1" ${purchaseOrders.status_order.id == 1 ? 'selected' : ''}>Borrador</option>
                                            <option value="2" ${purchaseOrders.status_order.id == 2 ? 'selected' : ''}>Enviada</option>
                                            <option value="3" ${purchaseOrders.status_order.id == 3 ? 'selected' : ''}>Aprobada</option>
                                            <option value="4" ${purchaseOrders.status_order.id == 4 ? 'selected' : ''}>Enviada al Proveedor</option>
                                            <option value="5" ${purchaseOrders.status_order.id == 5 ? 'selected' : ''}>En Proceso</option>
                                            <option value="6" ${purchaseOrders.status_order.id == 6 ? 'selected' : ''}>Parcialmente Recibida</option>
                                            <option value="7" ${purchaseOrders.status_order.id == 7 ? 'selected' : ''}>Recibida</option>
                                            <option value="8" ${purchaseOrders.status_order.id == 8 ? 'selected' : ''}>Facturada</option>
                                            <option value="9" ${purchaseOrders.status_order.id == 9 ? 'selected' : ''}>Cancelada</option>
                                            <option value="10" ${purchaseOrders.status_order.id == 10 ? 'selected' : ''}>Rechazada</option>
                                            <option value="11" ${purchaseOrders.status_order.id == 11 ? 'selected' : ''}>En Espera</option>
                                        </select>
                                    </td>
                                   
                                  

                                    <td>${purchaseOrders.subtotal}</td>
                                    <td>${purchaseOrders.tax_amount}</td>
                                   
                                    <td>${purchaseOrders.total}</td>                                  
                                   <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${purchaseOrders.id}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-info btn-sm details-purchase_order" data-id="${purchaseOrders.id}">
                                                <i class="fa fa-eye"></i></button>
                                            <button class="btn btn-success btn-sm print-pdf" 
                                                data-id="${purchaseOrders.id}">
                                            <i class="fa-solid fa-print"></i></button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${purchaseOrders.id}"><i class="fa-solid fa-trash"></i></button>
                                            <button class="btn btn-primary btn-sm send-email-btn" data-id="${purchaseOrders.id}">
                                                <i class="fa-solid fa-envelope"></i></button>
                                                 <button class="btn btn-secondary btn-sm generate-purchase-btn" data-id="${purchaseOrders.id}" title="Generar Compra">
                                                <i class="fa-solid fa-shopping-cart"></i></button>
                                        </td>
                                   
                                   </tr>`;
                        tableBody.append(row);
                        $('.details-purchase_order').on('click', handleDetailsPurchase);
                    });
                    $('#tb_purchases').DataTable();
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', error);
                }
            });
            // detalles
            
    });
    // detalle al dar click

    $(document).on('change', '.state-select', function() {
        var purchaseId = $(this).data('purchase-id');
        var newStateId = $(this).val();
        var previousStateId = $(this).data('current-state');
        
        if (confirm('¿Está seguro de cambiar el estado de esta compra, esto afectara tu inventario logico y fisico?')) {
            $.ajax({
                url: "{{ route('admin.purchase.update_state') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    purchase_id: purchaseId,
                    state_id: newStateId
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Estado actualizado correctamente',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Actualizar el atributo data-current-state
                        $('.state-select[data-purchase-id="' + purchaseId + '"]').data('current-state', newStateId);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Error al actualizar el estado'
                        });
                        // Revertir la selección al estado anterior
                        $('.state-select[data-purchase-id="' + purchaseId + '"]').val(previousStateId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el estado:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar el estado'
                    });
                    // Revertir la selección al estado anterior
                    $('.state-select[data-purchase-id="' + purchaseId + '"]').val(previousStateId);
                }
            });
        } else {
            // Si el usuario cancela, revertir la selección al estado anterior
            $(this).val(previousStateId);
        }
    });
</script>
<script>
     $(document).on('click', '.print-pdf', function() {
                // Get the purchase order ID from the data attribute
                var purchaseId = $(this).data('id');
                console.log('Purchase Order ID:', purchaseId); // Debug log
                
                if (!purchaseId) {
                    console.error('ID de la compra no encontrado');
                    alert('Error: No se pudo identificar la orden de compra');
                    return;
                }
                
                // Try a different approach to access the PDF
                var url = "{{ url('admin/purchase_order/export-pdf') }}/" + purchaseId;
                console.log('URL for PDF:', url); // Debug log
                
                // Open in a new window/tab
                window.open(url, '_blank');
    });
    function handleDetailsPurchase() {
        var purchaseId = $(this).data('id');
       // alert(purchaseId);

        // Redirect to the details page
        //admin.purchase_orders.show abrir

        window.location.href = "{{ url('admin/purchase_order/view') }}/" + purchaseId;
    }
    
    // Handle edit button click
    $(document).on('click', '.edit-btn', function() {
        var purchaseId = $(this).data('id');
        window.location.href = "{{ url('admin/purchase_order/edit') }}/" + purchaseId;
    });
    
    // Handle send email button click
    $(document).on('click', '.send-email-btn', function() {
        var purchaseId = $(this).data('id');
        console.log('Send email for purchase ID:', purchaseId);
        
        // Get purchase order details for email
        $.ajax({
            url: "{{ url('admin/purchase_order/get-details') }}/" + purchaseId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var purchaseOrder = response.data;
                    
                    // Show email form using SweetAlert2
                    Swal.fire({
                        title: 'Enviar Orden de Compra por Email',
                        html: `
                            <div class="mb-3">
                                <label for="emailTo" class="form-label">Destinatario</label>
                                <input type="email" class="form-control" id="emailTo" value="${purchaseOrder.suppliers.email || ''}">
                            </div>
                            <div class="mb-3">
                                <label for="emailSubject" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="emailSubject" value="Orden de Compra ${purchaseOrder.prefix}">
                            </div>
                            <div class="mb-3">
                                <label for="emailMessage" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="emailMessage" rows="3">Adjunto encontrará la orden de compra ${purchaseOrder.prefix}.</textarea>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Enviar',
                        cancelButtonText: 'Cancelar',
                        preConfirm: () => {
                            return {
                                to: document.getElementById('emailTo').value,
                                subject: document.getElementById('emailSubject').value,
                                message: document.getElementById('emailMessage').value
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading indicator
                            Swal.fire({
                                title: 'Enviando email...',
                                text: 'Por favor espere mientras se envía el email',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
                            // Send AJAX request to send the email
                            $.ajax({
                                url: "{{ url('admin/purchase_order/send-email') }}",
                                method: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    purchase_order_id: purchaseId,
                                    email_to: result.value.to,
                                    subject: result.value.subject,
                                    message: result.value.message
                                },
                                success: function(response) {
                                    console.log('Email response:', response); // Add debug log
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Enviado!',
                                            text: 'La orden de compra ha sido enviada por email correctamente.',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: response.message || 'Ocurrió un error al enviar el email.'
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error al enviar email:', error);
                                    console.error('Response text:', xhr.responseText); // Add detailed error info
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Ocurrió un error al enviar el email: ' + error
                                    });
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo obtener la información de la orden de compra.'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener detalles de la orden:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al obtener detalles de la orden de compra.'
                });
            }
        });
    });
    
    // Handle generate purchase button click
    $(document).on('click', '.generate-purchase-btn', function() {
        var purchaseOrderId = $(this).data('id');
        
        Swal.fire({
            title: '¿Generar Compra?',
            text: "¿Está seguro de generar una compra a partir de esta orden?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, generar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading indicator
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Generando compra a partir de la orden',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Send AJAX request to generate purchase
                $.ajax({
                    url: "{{ url('admin/purchase/generate-from-order') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        purchase_order_id: purchaseOrderId
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: 'Compra generada correctamente',
                                footer: `<a href="${response.purchase_url}">Ver compra generada</a>`
                            }).then(() => {
                                // Refresh the page to show updated status
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Error al generar la compra'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al generar compra:', error);
                        let errorMessage = 'Error al generar la compra';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    });
</script>

@endsection
  
      
