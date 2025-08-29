@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">
                        <i class="fas fa-plus-circle text-primary me-2"></i>
                        Nuevo Ajuste de Inventario
                    </h3>
                    <p class="text-muted mb-0">Crear un nuevo ajuste de inventario</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.inventory_ajusts.list')}}">Ajustes de Inventario</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nuevo Ajuste</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content-body">
        <div class="container-fluid">
            <!-- Progress Steps -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="step-item active">
                                    <div class="step-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <span class="step-label">Información General</span>
                                </div>
                                <div class="step-line"></div>
                                <div class="step-item">
                                    <div class="step-circle">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                    <span class="step-label">Productos</span>
                                </div>
                                <div class="step-line"></div>
                                <div class="step-item">
                                    <div class="step-circle">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <span class="step-label">Revisión</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="adjustmentForm" action="{{route('admin.inventory_ajusts.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Step 1: General Information -->
                <div class="step-content" id="step1">
                    <div class="row">
                        <!-- Main Information Card -->
                        <div class="col-lg-8">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Información General del Ajuste
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Adjustment Number (Auto-generated) -->
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="fas fa-hashtag text-muted me-1"></i>
                                                Número de Ajuste
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-hashtag"></i>
                                                </span>
                                                <input type="text" class="form-control bg-light" value="Se generará automáticamente" readonly>
                                            </div>
                                            <small class="text-muted">El número se asignará automáticamente al guardar</small>
                                        </div>

                                        <!-- Adjustment Date -->
                                        <div class="col-md-6">
                                            <label for="adjustment_date" class="form-label required">
                                                <i class="fas fa-calendar-alt text-muted me-1"></i>
                                                Fecha de Ajuste
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                                <input type="date" 
                                                       class="form-control @error('adjustment_date') is-invalid @enderror" 
                                                       id="adjustment_date" 
                                                       name="adjustment_date" 
                                                       value="{{ old('adjustment_date', date('Y-m-d')) }}" 
                                                       required>
                                            </div>
                                            @error('adjustment_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Warehouse -->
                                        <div class="col-md-6">
                                            <label for="warehouse_id" class="form-label required">
                                                <i class="fas fa-warehouse text-muted me-1"></i>
                                                Bodega
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-warehouse"></i>
                                                </span>
                                                <select class="form-select @error('warehouse_id') is-invalid @enderror" 
                                                        id="warehouse_id" 
                                                        name="warehouse_id" 
                                                        required>
                                                    <option value="">Seleccionar bodega...</option>
                                                    @foreach($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}" 
                                                                {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                            {{ $warehouse->warehouse_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('warehouse_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Adjustment Type -->
                                        <div class="col-md-6">
                                            <label for="adjustment_type_id" class="form-label required">
                                                <i class="fas fa-tags text-muted me-1"></i>
                                                Tipo de Ajuste
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-tags"></i>
                                                </span>
                                                <select class="form-select @error('adjustment_type_id') is-invalid @enderror" 
                                                        id="adjustment_type_id" 
                                                        name="adjustment_type_id" 
                                                        required>
                                                    <option value="">Seleccionar tipo...</option>
                                                    @foreach($adjustmentTypes as $type)
                                                        <option value="{{ $type->id }}" 
                                                                {{ old('adjustment_type_id') == $type->id ? 'selected' : '' }}>
                                                            {{ $type->type_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('adjustment_type_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Adjustment Reason -->
                                        <div class="col-12">
                                            <label for="reason_adjustment_id" class="form-label">
                                                <i class="fas fa-comment-alt text-muted me-1"></i>
                                                Razón del Ajuste
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-comment-alt"></i>
                                                </span>
                                                <select class="form-select @error('reason_adjustment_id') is-invalid @enderror" 
                                                        id="reason_adjustment_id" 
                                                        name="reason_adjustment_id">
                                                    <option value="">Seleccionar razón...</option>
                                                    @foreach($reasonAdjustments as $reason)
                                                        <option value="{{ $reason->id }}" 
                                                                {{ old('reason_adjustment_id') == $reason->id ? 'selected' : '' }}>
                                                            {{ $reason->reason_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('reason_adjustment_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Comments -->
                                        <div class="col-12">
                                            <label for="comments" class="form-label">
                                                <i class="fas fa-sticky-note text-muted me-1"></i>
                                                Comentarios y Observaciones
                                            </label>
                                            <textarea class="form-control @error('comments') is-invalid @enderror" 
                                                      id="comments" 
                                                      name="comments" 
                                                      rows="4" 
                                                      placeholder="Ingrese comentarios adicionales sobre el ajuste...">{{ old('comments') }}</textarea>
                                            @error('comments')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Máximo 65,535 caracteres</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary and Actions Card -->
                        <div class="col-lg-4">
                            <!-- Quick Summary -->
                            <div class="card shadow-sm mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-chart-line me-2"></i>
                                        Resumen del Ajuste
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center"></div>                                       <div class="col-6">
                                            <div class="border-end">
                                                <h4 class="text-primary mb-1" id="totalItems">0</h4>
                                                <small class="text-muted">Productos</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-success mb-1" id="totalValue">$0</h4>
                                            <small class="text-muted">Valor Total</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Support Document -->
                            <div class="card shadow-sm mb-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-paperclip me-2"></i>
                                        Documento de Soporte
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="support_document" class="form-label">
                                            <i class="fas fa-upload text-muted me-1"></i>
                                            Archivo de Soporte
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('support_document') is-invalid @enderror" 
                                               id="support_document" 
                                               name="support_document" 
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('support_document')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">
                                            Formatos: PDF, JPG, PNG. Máximo 2MB
                                        </small>
                                    </div>
                                    
                                    <!-- File Preview -->
                                    <div id="filePreview" class="d-none">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="fas fa-file-alt me-2"></i>
                                            <div>
                                                <strong>Archivo seleccionado:</strong><br>
                                                <span id="fileName"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Info -->
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Estado del Ajuste
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-secondary me-2">
                                            <i class="fas fa-edit me-1"></i>
                                            Borrador
                                        </span>
                                        <small class="text-muted">Estado inicial</small>
                                    </div>
                                    <small class="text-muted">
                                        El ajuste se creará en estado borrador y podrá ser editado antes de enviarlo para aprobación.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Products (Initially Hidden) -->
                <div class="step-content d-none" id="step2">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-boxes me-2"></i>
                                Productos del Ajuste
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Product Search -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <label class="form-label">
                                        <i class="fas fa-search text-muted me-1"></i>
                                        Buscar Producto
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" id="productSearch" placeholder="Buscar por código, nombre o código de barras...">
                                        <button type="button" class="btn btn-outline-primary" id="searchBtn">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Acciones</label>
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-success" id="addProductBtn">
                                            <i class="fas fa-plus me-1"></i>
                                            Agregar Producto
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Table -->
                            <div class="table-responsive">
                                <table class="table table-hover" id="productsTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="40">#</th>
                                            <th width="100">Código</th>
                                            <th>Producto</th>
                                            <th width="100">Stock Actual</th>
                                            <th width="120">Cantidad Ajuste</th>
                                            <th width="100">Nuevo Stock</th>
                                            <th width="120">Costo Unitario</th>
                                            <th width="120">Valor Total</th>
                                            <th width="80">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productsTableBody">
                                        <tr id="emptyRow">
                                            <td colspan="9" class="text-center text-muted py-4">
                                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                                <br>No hay productos agregados
                                                <br><small>Use el buscador para agregar productos al ajuste</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Review (Initially Hidden) -->
                <div class="step-content d-none" id="step3">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card shadow-sm">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-eye me-2"></i>
                                        Revisión Final
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="reviewContent">
                                        <!-- Content will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-calculator me-2"></i>
                                        Totales del Ajuste
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total Productos:</span>
                                        <strong id="reviewTotalItems">0</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Valor Total:</span>
                                        <strong class="text-primary" id="reviewTotalValue">$0</strong>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span><strong>Total Ajuste:</strong></span>
                                        <strong class="text-success" id="reviewFinalTotal">$0</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary" id="prevBtn" style="display: none;">
                                            <i class="fas fa-arrow-left me-1"></i>
                                            Anterior
                                        </button>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary" id="saveDraftBtn">
                                            <i class="fas fa-save me-1"></i>
                                            Guardar Borrador
                                        </button>
                                        <button type="button" class="btn btn-primary" id="nextBtn">
                                            Siguiente
                                            <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success d-none" id="submitBtn">
                                            <i class="fas fa-check me-1"></i>
                                            Crear Ajuste
                                        </button>
                                    </div>
                                    
                                    <div>
                                        <a href="{{route('admin.inventory_ajusts.list')}}" class="btn btn-outline-danger">
                                            <i class="fas fa-times me-1"></i>
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Product Search Modal -->
<div class="modal fade" id="productSearchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-search me-2"></i>
                    Buscar Productos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="modalProductSearch" placeholder="Buscar productos...">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="modalProductsBody">
                            <!-- Products will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .required::after {
        content: " *";
        color: #dc3545;
    }
    
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        flex: 1;
    }
    
    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    
    .step-item.active .step-circle {
        background-color: #0d6efd;
        color: white;
    }
    
    .step-item.completed .step-circle {
        background-color: #198754;
        color: white;
    }
    
    .step-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
        text-align: center;
    }
    
    .step-item.active .step-label {
        color: #0d6efd;
        font-weight: 600;
    }
    
    .step-line {
        height: 2px;
        background-color: #e9ecef;
        flex: 1;
        margin: 0 20px;
        margin-top: 20px;
    }
    
    .step-item.active ~ .step-line,
    .step-item.completed ~ .step-line {
        background-color: #0d6efd;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        font-weight: 600;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    @media (max-width: 768px) {
        .step-item {
            flex-direction: row;
            text-align: left;
        }
        
        .step-circle {
            margin-right: 10px;
            margin-bottom: 0;
        }
        
        .step-line {
            display: none;
        }
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    let currentStep = 1;
    let totalSteps = 3;
    let products = [];
    let productIndex = 0;

    // Helper function to ensure we always work with arrays
    function ensureArray(data) {
        if (Array.isArray(data)) {
            return data;
        } else if (data && Array.isArray(data.data)) {
            return data.data;
        } else if (data && typeof data === 'object') {
            return Object.values(data);
        } else {
            console.warn('Invalid data format, returning empty array:', data);
            return [];
        }
    }



    $(document).ready(function() {
        initializeForm();
        setupEventListeners();
        updateStepDisplay();
    });

    function initializeForm() {
        // Initialize date to today
        $('#adjustment_date').val(new Date().toISOString().split('T')[0]);
        
        // Initialize file upload preview
        $('#support_document').on('change', function() {
            const file = this.files[0];
            if (file) {
                $('#fileName').text(file.name);
                $('#filePreview').removeClass('d-none');
            } else {
                $('#filePreview').addClass('d-none');
            }
        });
    }

    function setupEventListeners() {
        // Navigation buttons
        $('#nextBtn').on('click', nextStep);
        $('#prevBtn').on('click', prevStep);
        $('#saveDraftBtn').on('click', saveDraft);
        
        // Product management
        $('#addProductBtn').on('click', showProductModal);
        $('#searchBtn').on('click', searchProducts);

        $('#productSearch').on('keypress', function(e) {
            if (e.which === 13) {
                searchProducts();
            }
        });
        
        // Form validation
        $('#adjustmentForm').on('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
        
        // Real-time calculations
        $(document).on('input', '.quantity-input, .cost-input', calculateRowTotal);
        $(document).on('change', '#warehouse_id, #adjustment_type_id', updateSummary);
    }

    function nextStep() {
        if (validateCurrentStep()) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStepDisplay();
                
                if (currentStep === 3) {
                    generateReview();
                }
            }
        }
    }

 // search

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    }

    function updateStepDisplay() {
        // Hide all steps
        $('.step-content').addClass('d-none');
        
        // Show current step
        $(`#step${currentStep}`).removeClass('d-none');
        
        // Update step indicators
        $('.step-item').removeClass('active completed');
        for (let i = 1; i <= totalSteps; i++) {
            if (i < currentStep) {
                $(`.step-item:nth-child(${i * 2 - 1})`).addClass('completed');
            } else if (i === currentStep) {
                $(`.step-item:nth-child(${i * 2 - 1})`).addClass('active');
            }
        }
        
        // Update navigation buttons
        $('#prevBtn').toggle(currentStep > 1);
        $('#nextBtn').toggle(currentStep < totalSteps);
        $('#submitBtn').toggle(currentStep === totalSteps);
        
        // Scroll to top
        $('html, body').animate({ scrollTop: 0 }, 300);
    }

    function validateCurrentStep() {
        let isValid = true;
        
        if (currentStep === 1) {
            // Validate general information
            const requiredFields = ['adjustment_date', 'warehouse_id', 'adjustment_type_id'];
            
            requiredFields.forEach(field => {
                const element = $(`#${field}`);
                if (!element.val()) {
                    element.addClass('is-invalid');
                    isValid = false;
                } else {
                    element.removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos Requeridos',
                    text: 'Por favor complete todos los campos obligatorios.'
                });
            }
        } else if (currentStep === 2) {
            // Validate products
            console.log('Validating products, current length:', products.length);
            console.log('Products array:', products);
            if (products.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin Productos',
                    text: 'Debe agregar al menos un producto al ajuste.'
                });
                isValid = false;
            }
        }
        
        return isValid;
    }

    function validateForm() {
        // Final validation before submit
        return validateCurrentStep();
    }

    function showProductModal() {
        $('#productSearchModal').modal('show');
        loadProducts();
    }

    function loadProducts() {
        const warehouseId = $('#warehouse_id').val();
        
        if (!warehouseId) {
            Swal.fire({
                icon: 'warning',
                title: 'Seleccione Bodega',
                text: 'Debe seleccionar una bodega antes de agregar productos.'
            });
            return;
        }
        
        // Show loading
        $('#modalProductsBody').html(`
            <tr>
                <td colspan="5" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <br>Cargando productos...
                </td>
            </tr>
        `);
        
        // Load products from warehouse
        $.ajax({
            url: '{{route("admin.items.by_warehouse")}}',
            method: 'GET',
            data: { warehouse_id: warehouseId },
            success: function(response) {
                console.log('Load products response:', response); // Debug log
                displayProducts(response.data || response);
            },
            error: function(xhr, status, error) {
                console.error('Error loading products:', error, xhr.responseText); // Debug log
                $('#modalProductsBody').html(`
                    <tr>
                        <td colspan="5" class="text-center text-danger py-4">
                            <i class="fas fa-exclamation-triangle"></i>
                            <br>Error al cargar productos
                            <br><small>${error}</small>
                        </td>
                    </tr>
                `);
            }
        });
    }

    function searchProducts() {
        const warehouseId = $('#warehouse_id').val();
        const searchTerm = $('#productSearch').val().trim();
        
        if (!warehouseId) {
            Swal.fire({
                icon: 'warning',
                title: 'Seleccione Bodega',
                text: 'Debe seleccionar una bodega antes de buscar productos.'
            });
            return;
        }

        if (!searchTerm) {
            Swal.fire({
                icon: 'info',
                title: 'Término de Búsqueda',
                text: 'Ingrese un término de búsqueda (código, nombre, código de barras).'
            });
            $('#productSearch').focus();
            return;
        }

        // Show loading in main table
        $('#productsTableBody').html(`
            <tr>
                <td colspan="9" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Buscando...</span>
                    </div>
                    <br>Buscando productos...
                </td>
            </tr>
        `);

        // Search products
        $.ajax({
            url: '{{route("admin.items.search-items")}}',
            method: 'GET',
            data: { 
                warehouse_id: warehouseId,
                search: searchTerm
            },
            success: function(response) {
                console.log('Search response:', response); // Debug log
                
                // Handle different response formats using helper function
                const searchResults = ensureArray(response.data || response);
                
                if (searchResults.length === 0) {
                    $('#productsTableBody').html(`
                        <tr id="emptyRow">
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-search fa-2x mb-2"></i>
                                <br>No se encontraron productos
                                <br><small>Intente con otro término de búsqueda</small>
                            </td>
                        </tr>
                    `);
                    return;
                }

                // Add found products to the adjustment
                let addedCount = 0;
                console.log('Found products to add:', searchResults.length);
                
                searchResults.forEach(product => {
                    // Check if product already exists in the global products array
                    const existingIndex = products.findIndex(p => p.id === product.id);
                    
                    if (existingIndex === -1) {
                        // Add product to global products array
                        const adjustmentProduct = {
                            id: product.id,
                            code: product.code || product.barcode || product.internal_code || product.sku,
                            name: product.name || product.product_name,
                            current_stock: product.stock || 0,
                            adjustment_quantity: 0,
                            unit_cost: product.cost || product.cost_price || 0,
                            total_value: 0,
                            index: productIndex++
                        };
                        
                        products.push(adjustmentProduct);
                        addedCount++;
                    }
                });
                
                console.log('Products added:', addedCount, 'Total products:', products.length);

                // Update table and summary
                updateProductsTable();
                updateSummary();

                // Clear search
                $('#productSearch').val('');

                // Show success message
                if (addedCount > 0) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Productos Agregados',
                        text: `${addedCount} producto(s) agregado(s) al ajuste desde la búsqueda: "${searchTerm}".`,
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Productos Existentes',
                        text: 'Los productos encontrados ya están en el ajuste.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error searching products:', error);
                
                $('#productsTableBody').html(`
                    <tr id="emptyRow">
                        <td colspan="9" class="text-center text-danger py-4">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <br>Error al buscar productos
                            <br><small>Intente nuevamente</small>
                        </td>
                    </tr>
                `);

                Swal.fire({
                    icon: 'error',
                    title: 'Error de Búsqueda',
                    text: 'Error al buscar productos. Intente nuevamente.'
                });
            }
        });
    }

    function displayProducts(productsData) {
        let html = '';
        
        if (productsData.length === 0) {
            html = `
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-box-open"></i>
                        <br>No hay productos disponibles
                    </td>
                </tr>
            `;
        } else {
            // Ensure productsData is an array before using forEach
            const productsList = ensureArray(productsData);
            productsList.forEach(product => {
                html += `
                    <tr>
                        <td>${product.barcode}</td>
                        <td>${product.product_name}</td>
                        <td>${product.stock || 0}</td>
                        <td>$${formatNumber(product.cost || 0)}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary add-product-btn" 
                                    data-product='${JSON.stringify(product)}'>
                                <i class="fas fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#modalProductsBody').html(html);
        
        // Attach event listeners
        $('.add-product-btn').on('click', function() {
            const product = JSON.parse($(this).attr('data-product'));
            addProductToAdjustment(product);
        });
    }

    function addProductToAdjustment(product) {
        // Check if product already exists
        const existingIndex = products.findIndex(p => p.id === product.id);
        
        if (existingIndex !== -1) {
            Swal.fire({
                icon: 'info',
                title: 'Producto Existente',
                text: 'Este producto ya está en el ajuste.'
            });
            return;
        }
        
        // Add product to array
        const adjustmentProduct = {
            id: product.id,
            code: product.barcode,
            name: product.porduct_name,
            current_stock: product.stock || 0,
            adjustment_quantity: 0,
            unit_cost: product.cost || 0,
            total_value: 0,
            index: productIndex++
        };
        
        products.push(adjustmentProduct);
        
        // Update table
        updateProductsTable();
        updateSummary();
        
        // Close modal
        $('#productSearchModal').modal('hide');
        
        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Producto Agregado',
            text: `${product.name} ha sido agregado al ajuste.`,
            timer: 2000,
            showConfirmButton: false
        });
    }

    function updateProductsTable() {
        console.log('Updating products table, products length:', products.length);
        const tbody = $('#productsTableBody');
        
        if (products.length === 0) {
            tbody.html(`
                <tr id="emptyRow">
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-boxes fa-2x mb-2"></i>
                        <br>No hay productos agregados
                        <br><small>Use el buscador para agregar productos al ajuste</small>
                    </td>
                </tr>
            `);
            return;
        }
        
        let html = '';
        products.forEach((product, index) => {
            const newStock = product.current_stock + product.adjustment_quantity;
            
            html += `
                <tr data-index="${product.index}">
                    <td>${index + 1}</td>
                    <td><strong>${product.code}</strong></td>
                    <td>${product.name}</td>
                    <td class="text-center">${product.current_stock}</td>
                    <td>
                        <input type="number" 
                               class="form-control form-control-sm quantity-input" 
                               value="${product.adjustment_quantity}" 
                               data-index="${product.index}"
                               step="0.01">
                    </td>
                    <td class="text-center ${newStock < 0 ? 'text-danger' : ''}">${newStock}</td>
                    <td>
                        <input type="number" 
                               class="form-control form-control-sm cost-input" 
                               value="${product.unit_cost}" 
                               data-index="${product.index}"
                               step="0.01">
                    </td>
                    <td class="text-end">$${formatNumber(product.total_value)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-product-btn" 
                                data-index="${product.index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        tbody.html(html);
        
        // Attach event listeners
        $('.remove-product-btn').on('click', function() {
            const index = $(this).data('index');
            removeProduct(index);
        });
    }

    function calculateRowTotal() {
        const index = $(this).data('index');
        const product = products.find(p => p.index === index);
        
        if (!product) return;
        
        if ($(this).hasClass('quantity-input')) {
            product.adjustment_quantity = parseFloat($(this).val()) || 0;
        } else if ($(this).hasClass('cost-input')) {
            product.unit_cost = parseFloat($(this).val()) || 0;
        }
        
        product.total_value = Math.abs(product.adjustment_quantity) * product.unit_cost;
        
        // Update display
        const row = $(this).closest('tr');
        row.find('td:nth-child(6)').text(product.current_stock + product.adjustment_quantity);
        row.find('td:nth-child(8)').text('$' + formatNumber(product.total_value));
        
        updateSummary();
    }

    function removeProduct(index) {
        products = products.filter(p => p.index !== index);
        updateProductsTable();
        updateSummary();
    }

    function updateSummary() {
        const totalItems = products.length;
        const totalValue = products.reduce((sum, product) => sum + product.total_value, 0);
        
        $('#totalItems').text(totalItems);
        $('#totalValue').text('$' + formatNumber(totalValue));
    }

    function generateReview() {
        const warehouseName = $('#warehouse_id option:selected').text();
        const adjustmentType = $('#adjustment_type_id option:selected').text();
        const adjustmentReason = $('#reason_adjustment_id option:selected').text();
        const adjustmentDate = $('#adjustment_date').val();
        const comments = $('#comments').val();
        
        let html = `
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6><i class="fas fa-warehouse text-primary me-2"></i>Bodega:</h6>
                    <p class="mb-2">${warehouseName}</p>
                    
                    <h6><i class="fas fa-tags text-primary me-2"></i>Tipo de Ajuste:</h6>
                    <p class="mb-2">${adjustmentType}</p>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-calendar text-primary me-2"></i>Fecha:</h6>
                    <p class="mb-2">${new Date(adjustmentDate).toLocaleDateString('es-CO')}</p>
                    
                    <h6><i class="fas fa-comment-alt text-primary me-2"></i>Razón:</h6>
                    <p class="mb-2">${adjustmentReason || 'No especificada'}</p>
                </div>
            </div>
        `;
        
        if (comments) {
            html += `
                <div class="mb-4">
                    <h6><i class="fas fa-sticky-note text-primary me-2"></i>Comentarios:</h6>
                    <p class="bg-light p-3 rounded">${comments}</p>
                </div>
            `;
        }
        
        html += `
            <h6><i class="fas fa-boxes text-primary me-2"></i>Productos (${products.length}):</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Stock Actual</th>
                            <th class="text-center">Ajuste</th>
                            <th class="text-center">Nuevo Stock</th>
                            <th class="text-end">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        products.forEach(product => {
            const newStock = product.current_stock + product.adjustment_quantity;
            html += `
                <tr>
                    <td>
                        <strong>${product.code}</strong><br>
                        <small class="text-muted">${product.name}</small>
                    </td>
                    <td class="text-center">${product.current_stock}</td>
                    <td class="text-center ${product.adjustment_quantity >= 0 ? 'text-success' : 'text-danger'}">
                        ${product.adjustment_quantity >= 0 ? '+' : ''}${product.adjustment_quantity}
                    </td>
                    <td class="text-center ${newStock < 0 ? 'text-danger' : ''}">${newStock}</td>
                    <td class="text-end">$${formatNumber(product.total_value)}</td>
                </tr>
            `;
        });
        
        html += `
                    </tbody>
                </table>
            </div>
        `;
        
        $('#reviewContent').html(html);
        
        // Update totals
        const totalItems = products.length;
        const totalValue = products.reduce((sum, product) => sum + product.total_value, 0);
        
        $('#reviewTotalItems').text(totalItems);
        $('#reviewTotalValue').text('$' + formatNumber(totalValue));
        $('#reviewFinalTotal').text('$' + formatNumber(totalValue));
    }

    function saveDraft() {
        // Add draft flag to form
        $('<input>').attr({
            type: 'hidden',
            name: 'save_as_draft',
            value: '1'
        }).appendTo('#adjustmentForm');
        
        // Add products data
        $('<input>').attr({
            type: 'hidden',
            name: 'products_data',
            value: JSON.stringify(products)
        }).appendTo('#adjustmentForm');
        
        $('#adjustmentForm').submit();
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        }).format(number);
    }

    // Search products in modal
    $('#modalProductSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('#modalProductsBody tr').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(searchTerm));
        });
    });
</script>
@endsection