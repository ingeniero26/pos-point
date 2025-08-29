@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">
                        <i class="fas fa-boxes text-primary me-2"></i>
                        Ajustes de Inventario
                    </h3>
                    <p class="text-muted mb-0">Gestión de ajustes de inventario</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Ajustes de inventario
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content-body">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0" id="totalAdjustments">0</h4>
                                    <p class="mb-0">Total Ajustes</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-boxes fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0" id="approvedAdjustments">0</h4>
                                    <p class="mb-0">Aprobados</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0" id="pendingAdjustments">0</h4>
                                    <p class="mb-0">Pendientes</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0" id="totalValue">$0</h4>
                                    <p class="mb-0">Valor Total</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-filter text-primary me-2"></i>
                                    Filtros de Búsqueda
                                </h5>
                                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                                    <i class="fas fa-chevron-down"></i> Mostrar/Ocultar
                                </button>
                            </div>
                        </div>
                        <div class="card-body collapse show" id="filterCollapse">
                            <form id="filterForm" class="row g-3">
                                <div class="col-md-3">
                                    <label for="date_from" class="form-label">
                                        <i class="fas fa-calendar-alt text-muted me-1"></i>
                                        Fecha desde
                                    </label>
                                    <input type="date" class="form-control" id="date_from" name="date_from">
                                </div>
                                <div class="col-md-3">
                                    <label for="date_to" class="form-label">
                                        <i class="fas fa-calendar-alt text-muted me-1"></i>
                                        Fecha hasta
                                    </label>
                                    <input type="date" class="form-control" id="date_to" name="date_to">
                                </div>
                                <div class="col-md-3">
                                    <label for="warehouse_id" class="form-label">
                                        <i class="fas fa-warehouse text-muted me-1"></i>
                                        Bodega
                                    </label>
                                    <select class="form-select" id="warehouse_id" name="warehouse_id">
                                        <option value="">Todas las bodegas</option>
                                        <!-- Se llenará dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="adjustment_type_id" class="form-label">
                                        <i class="fas fa-tags text-muted me-1"></i>
                                        Tipo de Ajuste
                                    </label>
                                    <select class="form-select" id="adjustment_type_id" name="adjustment_type_id">
                                        <option value="">Todos los tipos</option>
                                        <!-- Se llenará dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="status" class="form-label">
                                        <i class="fas fa-flag text-muted me-1"></i>
                                        Estado
                                    </label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">Todos los estados</option>
                                        <option value="draft">Borrador</option>
                                        <option value="pending">Pendiente</option>
                                        <option value="approved">Aprobado</option>
                                        <option value="rejected">Rechazado</option>
                                        <option value="cancelled">Cancelado</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="adjustment_reason_id" class="form-label">
                                        <i class="fas fa-comment text-muted me-1"></i>
                                        Razón de Ajuste
                                    </label>
                                    <select class="form-select" id="adjustment_reason_id" name="adjustment_reason_id">
                                        <option value="">Todas las razones</option>
                                        <!-- Se llenará dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="created_by" class="form-label">
                                        <i class="fas fa-user text-muted me-1"></i>
                                        Usuario
                                    </label>
                                    <select class="form-select" id="created_by" name="created_by">
                                        <option value="">Todos los usuarios</option>
                                        <!-- Se llenará dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="search" class="form-label">
                                        <i class="fas fa-search text-muted me-1"></i>
                                        Búsqueda general
                                    </label>
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Número, comentarios...">
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="button" id="applyFilters" class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i>
                                            Aplicar Filtros
                                        </button>
                                        <button type="button" id="resetFilters" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i>
                                            Limpiar Filtros
                                        </button>
                                        <button type="button" id="toggleAdvanced" class="btn btn-outline-info">
                                            <i class="fas fa-cog me-1"></i>
                                            Filtros Avanzados
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0">
                                        <i class="fas fa-list text-primary me-2"></i>
                                        Listado de Ajustes de Inventario
                                    </h4>
                                    <small class="text-muted">Gestiona todos los ajustes de inventario</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{url('admin/inventory_ajusts/create')}}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Nuevo Ajuste
                                        </a>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="fas fa-download me-1"></i> Exportar
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" id="exportExcel">
                                                    <i class="fas fa-file-excel text-success me-2"></i>Excel
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" id="exportPdf">
                                                    <i class="fas fa-file-pdf text-danger me-2"></i>PDF
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#" id="exportCsv">
                                                    <i class="fas fa-file-csv text-info me-2"></i>CSV
                                                </a></li>
                                            </ul>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary" id="refreshTable">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="tb_adjustments">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center" width="60">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th width="80">ID</th>
                                            <th width="120">Número</th>
                                            <th width="150">Bodega</th>
                                            <th width="130">Tipo</th>
                                            <th width="150">Razón</th>
                                            <th width="100">Fecha</th>
                                            <th width="100">Estado</th>
                                            <th width="120">Usuario</th>
                                            <th width="100">F. Aprobación</th>
                                            <th width="120">Aprobado por</th>
                                            <th width="200">Comentarios</th>
                                            <th width="120">Documento</th>
                                            <th width="100" class="text-end">Total</th>
                                            <th width="150" class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Se llenará con AJAX -->
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Loading State -->
                            <div id="loadingState" class="text-center py-5" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <p class="mt-2 text-muted">Cargando ajustes de inventario...</p>
                            </div>
                            
                            <!-- Empty State -->
                            <div id="emptyState" class="text-center py-5" style="display: none;">
                                <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay ajustes de inventario</h5>
                                <p class="text-muted">No se encontraron ajustes que coincidan con los filtros aplicados.</p>
                                <a href="{{url('admin/inventory_ajusts/create')}}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> Crear Primer Ajuste
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-3">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Mostrando <span id="showingCount">0</span> de <span id="totalCount">0</span> registros
                                        </small>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-danger" id="bulkDelete" disabled>
                                                <i class="fas fa-trash me-1"></i> Eliminar Seleccionados
                                            </button>
                                            <button type="button" class="btn btn-outline-warning" id="bulkApprove" disabled>
                                                <i class="fas fa-check me-1"></i> Aprobar Seleccionados
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end align-items-center gap-3">
                                        <div class="text-end">
                                            <small class="text-muted d-block">Total Valor Ajustes:</small>
                                            <strong class="text-primary" id="totalAdjustmentValue">$0</strong>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block">Última Actualización:</small>
                                            <small class="text-muted" id="lastUpdate">-</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    let adjustmentsTable;
    let warehouses = [];
    let adjustmentTypes = [];
    let adjustmentReasons = [];
    let users = [];
    let selectedAdjustments = [];
    // Load filter options
    function loadFilterOptions() {
        // Load warehouses
        $.get('{{route("admin.warehouses.fetch")}}', function(data) {
            warehouses = data;
            let options = '<option value="">Todas las bodegas</option>';
            data.forEach(warehouse => {
                options += `<option value="${warehouse.id}">${warehouse.warehouse_name}</option>`;
            });
            $('#warehouse_id').html(options);
        });

      

        // Load adjustment reasons
        $.get('{{route("admin.adjustment_reason.fetch")}}', function(data) {
            adjustmentReasons = data;
            let options = '<option value="">Todas las razones</option>';
            data.forEach(reason => {
                options += `<option value="${reason.id}">${reason.reason_name}</option>`;
            });
            $('#adjustment_reason_id').html(options);
        });

      
    }

    // Function to get status badge
    function getStatusBadge(status) {
        const badges = {
            'draft': '<span class="badge bg-secondary"><i class="fas fa-edit me-1"></i>Borrador</span>',
            'pending': '<span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Pendiente</span>',
            'approved': '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Aprobado</span>',
            'rejected': '<span class="badge bg-danger"><i class="fas fa-times me-1"></i>Rechazado</span>',
            'cancelled': '<span class="badge bg-dark"><i class="fas fa-ban me-1"></i>Cancelado</span>'
        };
        return badges[status] || `<span class="badge bg-light text-dark">${status}</span>`;
    }

    // Function to format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        }).format(amount || 0);
    }

    // Function to load adjustments with filters
    function loadAdjustments(filters = {}) {
        // Show loading state
        $('#loadingState').show();
        $('#emptyState').hide();
        
        if (adjustmentsTable) {
            adjustmentsTable.destroy();
        }
        
        $.ajax({
            url: '{{route("admin.inventory_ajusts.fetch")}}',
            method: 'GET',
            dataType: 'json',
            data: filters,
            success: function(response) {
                $('#loadingState').hide();
                
                const data = response.data || response;
                const stats = response.stats || {};
                
                var tableBody = $('#tb_adjustments tbody');
                tableBody.empty();
                
                if (data.length === 0) {
                    $('#emptyState').show();
                    return;
                }

                let totalAmount = 0;
                let approvedCount = 0;
                let pendingCount = 0;

                $.each(data, function(index, adjustment) {
                    const adjustmentDate = new Date(adjustment.adjustment_date).toLocaleDateString('es-CO');
                    const approvalDate = adjustment.approval_date ? 
                        new Date(adjustment.approval_date).toLocaleDateString('es-CO') : '-';
                    
                    totalAmount += parseFloat(adjustment.total_value || 0);
                    
                    if (adjustment.status === 'approved') approvedCount++;
                    if (adjustment.status === 'pending') pendingCount++;
                    
                    const row = `
                        <tr data-id="${adjustment.id}">
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input adjustment-checkbox" value="${adjustment.id}">
                            </td>
                            <td><span class="badge bg-light text-dark">#${adjustment.id}</span></td>
                            <td>
                                <strong>${adjustment.adjustment_number}</strong>
                                <br><small class="text-muted">${adjustment.uuid || ''}</small>
                            </td>
                            <td>
                                <i class="fas fa-warehouse text-primary me-1"></i>
                                ${adjustment.warehouse ? adjustment.warehouse.warehouse_name : 'N/A'}
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    ${adjustment.adjustment_type ? adjustment.adjustment_type.type_name : 'N/A'}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    ${adjustment.adjustment_reason ? adjustment.adjustment_reason.reason_name : 'N/A'}
                                </small>
                            </td>
                            <td>
                                <i class="fas fa-calendar text-muted me-1"></i>
                                ${adjustmentDate}
                            </td>
                            <td>${getStatusBadge(adjustment.status)}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-muted me-2"></i>
                                    <div>
                                        <small>${adjustment.created_by ? adjustment.created_by.name : 'N/A'}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-calendar-check text-muted me-1"></i>
                                ${approvalDate}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-check text-muted me-2"></i>
                                    <div>
                                        <small>${adjustment.user_approval ? adjustment.user_approval.name : 'N/A'}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 150px;" title="${adjustment.comments || ''}">
                                    ${adjustment.comments || '-'}
                                </span>
                            </td>
                            <td>
                                ${adjustment.support_document ? 
                                    `<a href="#" class="btn btn-sm btn-outline-primary view-document" data-document="${adjustment.support_document}">
                                        <i class="fas fa-file-alt"></i>
                                    </a>` : '-'
                                }
                            </td>
                            <td class="text-end">
                                <strong class="text-primary">${formatCurrency(adjustment.total_value)}</strong>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info details-adjustment" data-id="${adjustment.id}" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success print-pdf" data-id="${adjustment.id}" title="Imprimir">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    ${adjustment.status === 'draft' ? 
                                        `<button class="btn btn-outline-primary edit-adjustment" data-id="${adjustment.id}" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>` : ''
                                    }
                                    ${adjustment.status === 'pending' ? 
                                        `<button class="btn btn-outline-warning approve-adjustment" data-id="${adjustment.id}" title="Aprobar">
                                            <i class="fas fa-check"></i>
                                        </button>` : ''
                                    }
                                    <button class="btn btn-outline-danger delete-btn" data-id="${adjustment.id}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                    tableBody.append(row);
                });
                
                // Update statistics
                updateStatistics(data.length, approvedCount, pendingCount, totalAmount);
                
                // Initialize DataTable
                adjustmentsTable = $('#tb_adjustments').DataTable({
                    responsive: true,
                    pageLength: 25,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                    },
                    dom: 'rt<"d-flex justify-content-between align-items-center"<"d-flex align-items-center"l><"d-flex align-items-center"p>>',
                    columnDefs: [
                        { orderable: false, targets: [0, -1] }
                    ],
                    order: [[1, 'desc']]
                });
                
                // Update footer info
                updateFooterInfo();
            },
            error: function(xhr, status, error) {
                $('#loadingState').hide();
                console.error('Error al obtener los datos:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los ajustes de inventario'
                });
            }
        });
    }

    // Update statistics cards
    function updateStatistics(total, approved, pending, totalValue) {
        $('#totalAdjustments').text(total);
        $('#approvedAdjustments').text(approved);
        $('#pendingAdjustments').text(pending);
        $('#totalValue').text(formatCurrency(totalValue));
    }

    // Update footer information
    function updateFooterInfo() {
        const info = adjustmentsTable.page.info();
        $('#showingCount').text(info.recordsDisplay);
        $('#totalCount').text(info.recordsTotal);
        $('#totalAdjustmentValue').text(formatCurrency(calculateTotalValue()));
        $('#lastUpdate').text(new Date().toLocaleString('es-CO'));
    }

    // Calculate total value from visible rows
    function calculateTotalValue() {
        let total = 0;
        $('#tb_adjustments tbody tr:visible').each(function() {
            const valueText = $(this).find('td:nth-last-child(2)').text();
            const value = parseFloat(valueText.replace(/[^\d.-]/g, '')) || 0;
            total += value;
        });
        return total;
    }

    $(document).on('click', '.send-email-btn', function() {
        var quotationId = $(this).data('id');
        console.log('Send email for quotation ID:', quotationId);
        
        // Get quotation details for email
        $.ajax({
            url: "{{ url('admin/quotation/get-details') }}/" + quotationId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var quotation = response.data;
                    
                    // Show email form using SweetAlert2
                    Swal.fire({
                        title: 'Enviar Cotización por Email',
                        html: `
                            <div class="mb-3">
                                <label for="emailTo" class="form-label">Destinatario</label>
                                <input type="email" class="form-control" id="emailTo" value="${quotation.customer ? quotation.customer.email || '' : ''}">
                            </div>
                            <div class="mb-3">
                                <label for="emailSubject" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="emailSubject" value="Cotización ${quotation.number}">
                            </div>
                            <div class="mb-3">
                                <label for="emailMessage" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="emailMessage" rows="3">Adjunto encontrará la cotización ${quotation.number}.</textarea>
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
                                url: "{{ url('admin/quotation/send-email') }}",
                                method: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    quotation_id: quotationId,
                                    email_to: result.value.to,
                                    subject: result.value.subject,
                                    message: result.value.message
                                },
                                success: function(response) {
                                    console.log('Email response:', response);
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Enviado!',
                                            text: 'La cotización ha sido enviada por email correctamente.',
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
                                    console.error('Response text:', xhr.responseText);
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
                        text: 'No se pudo obtener la información de la cotización.'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener detalles de la cotización:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al obtener detalles de la cotización.'
                });
            }
        });
    });
    
    // Initialize page
    $(document).ready(function() {
        loadFilterOptions();
        loadAdjustments();
        
        // Event listeners for filters
        $('#applyFilters').on('click', function() {
            const filters = {
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val(),
                warehouse_id: $('#warehouse_id').val(),
                adjustment_type_id: $('#adjustment_type_id').val(),
                adjustment_reason_id: $('#adjustment_reason_id').val(),
                status: $('#status').val(),
                created_by: $('#created_by').val(),
                search: $('#search').val()
            };
            loadAdjustments(filters);
        });
        
        $('#resetFilters').on('click', function() {
            $('#filterForm')[0].reset();
            loadAdjustments();
        });

        // Refresh table
        $('#refreshTable').on('click', function() {
            $(this).find('i').addClass('fa-spin');
            loadAdjustments();
            setTimeout(() => {
                $(this).find('i').removeClass('fa-spin');
            }, 1000);
        });

        // Select all checkboxes
        $('#selectAll').on('change', function() {
            $('.adjustment-checkbox').prop('checked', this.checked);
            updateBulkActions();
        });

        // Individual checkbox change
        $(document).on('change', '.adjustment-checkbox', function() {
            updateBulkActions();
            updateSelectAll();
        });

        // Bulk actions
        $('#bulkDelete').on('click', handleBulkDelete);
        $('#bulkApprove').on('click', handleBulkApprove);
        
        // Export buttons
        $('#exportExcel').on('click', function() {
            window.location.href = "{{ route('admin.inventory_ajusts.export.excel') }}";
        });
        
        $('#exportPdf').on('click', function() {
            window.location.href = "{{ route('admin.inventory_ajusts.export.pdf') }}";
        });

        $('#exportCsv').on('click', function() {
            window.location.href = "{{ route('admin.inventory_ajusts.export.csv') }}";
        });
        
        // Event delegation for dynamic elements
        $(document).on('click', '.details-adjustment', handleDetailsAdjustment);
        $(document).on('click', '.edit-adjustment', handleEditAdjustment);
        $(document).on('click', '.approve-adjustment', handleApproveAdjustment);
        $(document).on('click', '.delete-btn', handleDelete);
        $(document).on('click', '.print-pdf', handlePrintPdf);
        $(document).on('click', '.view-document', handleViewDocument);

        // Advanced filters toggle
        $('#toggleAdvanced').on('click', function() {
            $('.advanced-filter').toggle();
            const icon = $(this).find('i');
            icon.toggleClass('fa-cog fa-cog-alt');
        });

        // Real-time search
        $('#search').on('input', debounce(function() {
            $('#applyFilters').click();
        }, 500));
    });

    // Update bulk action buttons
    function updateBulkActions() {
        const checkedCount = $('.adjustment-checkbox:checked').length;
        $('#bulkDelete, #bulkApprove').prop('disabled', checkedCount === 0);
    }

    // Update select all checkbox
    function updateSelectAll() {
        const totalCheckboxes = $('.adjustment-checkbox').length;
        const checkedCheckboxes = $('.adjustment-checkbox:checked').length;
        
        $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0);
    }

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Handle details button click
    function handleDetailsAdjustment() {
        const adjustmentId = $(this).data('id');
        
        if (!adjustmentId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo identificar el ajuste'
            });
            return;
        }

        // Redirect to details page
        Swal.fire({
            title: 'Cargando detalles...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
                window.location.href = "{{ url('admin/inventory_ajusts') }}/" + adjustmentId;
            }
        });
    }

    // Handle edit button click
    function handleEditAdjustment() {
        const adjustmentId = $(this).data('id');
        window.location.href = "{{ url('admin/inventory_ajusts') }}/" + adjustmentId + "/edit";
    }

    // Handle approve button click
    function handleApproveAdjustment() {
        const adjustmentId = $(this).data('id');
        
        Swal.fire({
            title: '¿Aprobar ajuste?',
            text: "Esta acción aprobará el ajuste de inventario",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, aprobar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.inventory_ajusts.approve', ['id' => ':id']) }}".replace(':id', adjustmentId),
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Aprobado!',
                                text: 'El ajuste ha sido aprobado correctamente',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadAdjustments();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se pudo aprobar el ajuste'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al aprobar el ajuste'
                        });
                    }
                });
            }
        });
    }

    // Handle print PDF
    function handlePrintPdf() {
        const adjustmentId = $(this).data('id');
        
        if (!adjustmentId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo identificar el ajuste'
            });
            return;
        }
        
        const url = "{{ route('admin.inventory_ajusts.pdf', ['id' => ':id']) }}".replace(':id', adjustmentId);
        window.open(url, '_blank');
    }

    // Handle view document
    function handleViewDocument() {
        const document = $(this).data('document');
        
        if (document) {
            const url = "{{ asset('storage/adjustments/documents/') }}/" + document;
            window.open(url, '_blank');
        }
    }

    // Handle bulk delete
    function handleBulkDelete() {
        const selectedIds = $('.adjustment-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) return;

        Swal.fire({
            title: '¿Eliminar ajustes seleccionados?',
            text: `Se eliminarán ${selectedIds.length} ajuste(s). Esta acción no se puede revertir.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.inventory_ajusts.bulk_delete') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminados!',
                                text: `${selectedIds.length} ajuste(s) eliminado(s) correctamente`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadAdjustments();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se pudieron eliminar los ajustes'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar los ajustes'
                        });
                    }
                });
            }
        });
    }

    // Handle bulk approve
    function handleBulkApprove() {
        const selectedIds = $('.adjustment-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) return;

        Swal.fire({
            title: '¿Aprobar ajustes seleccionados?',
            text: `Se aprobarán ${selectedIds.length} ajuste(s).`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, aprobar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.inventory_ajusts.bulk_approve') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Aprobados!',
                                text: `${selectedIds.length} ajuste(s) aprobado(s) correctamente`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadAdjustments();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se pudieron aprobar los ajustes'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al aprobar los ajustes'
                        });
                    }
                });
            }
        });
    }
    // Handle delete adjustment
    function handleDelete() {
        const adjustmentId = $(this).data('id');
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.inventory_ajusts.destroy', ['id' => ':id']) }}".replace(':id', adjustmentId),
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'El ajuste ha sido eliminado correctamente',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadAdjustments();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se pudo eliminar el ajuste'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al eliminar el ajuste:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar el ajuste'
                        });
                    }
                });
            }
        });
    }
    // Initialize tooltips and other UI components
    $(function () {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Initialize filter collapse
        $('#filterCollapse').on('shown.bs.collapse', function () {
            $('#date_from').focus();
        });

        // Auto-hide alerts
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);

        // Initialize date inputs with current month
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        $('#date_from').val(firstDay.toISOString().split('T')[0]);
        $('#date_to').val(today.toISOString().split('T')[0]);
    });
</script>

@endsection
  
      
