@extends('layouts.app')

@section('title', 'Editar Oportunidad')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Editar Oportunidad</h3>
                    <div class="btn-group">
                        <a href="{{ route('opportunities.show', $opportunity) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('opportunities.update', $opportunity) }}" method="POST" id="opportunityForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información básica -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-muted mb-3">
                                    <i class="fas fa-info-circle"></i> Información Básica
                                </h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre de la Oportunidad <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $opportunity->name) }}" 
                                           required
                                           maxlength="200">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stage_id" class="form-label">Etapa <span class="text-danger">*</span></label>
                                    <select class="form-select @error('stage_id') is-invalid @enderror" 
                                            id="stage_id" 
                                            name="stage_id" 
                                            required>
                                        <option value="">Seleccionar etapa</option>
                                        @foreach($stages as $stage)
                                            <option value="{{ $stage->id }}" 
                                                    data-percentage="{{ $stage->closing_percentage }}"
                                                    data-is-closing="{{ $stage->is_closing_stage ? 'true' : 'false' }}"
                                                    {{ old('stage_id', $opportunity->stage_id) == $stage->id ? 'selected' : '' }}>
                                                {{ $stage->name }} ({{ $stage->closing_percentage }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('stage_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3"
                                              maxlength="500">{{ old('description', $opportunity->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Máximo 500 caracteres</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de contacto -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-muted mb-3">
                                    <i class="fas fa-user"></i> Información de Contacto
                                </h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="third_id" class="form-label">Cliente/Tercero</label>
                                    <select class="form-select @error('third_id') is-invalid @enderror" 
                                            id="third_id" 
                                            name="third_id">
                                        <option value="">Seleccionar cliente</option>
                                        @foreach($contacts as $contact)
                                            <option value="{{ $contact->id }}" 
                                                    data-name="{{ $contact->name }}"
                                                    data-email="{{ $contact->email }}"
                                                    data-phone="{{ $contact->phone }}"
                                                    {{ old('third_id', $opportunity->third_id) == $contact->id ? 'selected' : '' }}>
                                                {{ $contact->name }} - {{ $contact->identification }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('third_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_name" class="form-label">Nombre del Contacto <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('contact_name') is-invalid @enderror" 
                                           id="contact_name" 
                                           name="contact_name" 
                                           value="{{ old('contact_name', $opportunity->contact_name) }}" 
                                           required
                                           maxlength="500">
                                    @error('contact_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Email del Contacto</label>
                                    <input type="email" 
                                           class="form-control @error('contact_email') is-invalid @enderror" 
                                           id="contact_email" 
                                           name="contact_email" 
                                           value="{{ old('contact_email', $opportunity->contact_email) }}"
                                           maxlength="500">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Teléfono del Contacto</label>
                                    <input type="text" 
                                           class="form-control @error('contact_phone') is-invalid @enderror" 
                                           id="contact_phone" 
                                           name="contact_phone" 
                                           value="{{ old('contact_phone', $opportunity->contact_phone) }}"
                                           maxlength="500">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información comercial -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-muted mb-3">
                                    <i class="fas fa-dollar-sign"></i> Información Comercial
                                </h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="estimated_value" class="form-label">Valor Estimado <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               class="form-control @error('estimated_value') is-invalid @enderror" 
                                               id="estimated_value" 
                                               name="estimated_value" 
                                               value="{{ old('estimated_value', $opportunity->estimated_value) }}" 
                                               min="0" 
                                               step="0.01"
                                               required>
                                        @error('estimated_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="probability" class="form-label">Probabilidad de Cierre <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control @error('probability') is-invalid @enderror" 
                                               id="probability" 
                                               name="probability" 
                                               value="{{ old('probability', $opportunity->probability) }}" 
                                               min="0" 
                                               max="100" 
                                               step="1"
                                               required>
                                        <span class="input-group-text">%</span>
                                        @error('probability')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Valor entre 0 y 100</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="estimated_closing_date" class="form-label">Fecha Estimada de Cierre</label>
                                    <input type="date" 
                                           class="form-control @error('estimated_closing_date') is-invalid @enderror" 
                                           id="estimated_closing_date" 
                                           name="estimated_closing_date" 
                                           value="{{ old('estimated_closing_date', $opportunity->estimated_closing_date ? $opportunity->estimated_closing_date->format('Y-m-d') : '') }}">
                                    @error('estimated_closing_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-muted mb-3">
                                    <i class="fas fa-cogs"></i> Información Adicional
                                </h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="source_id" class="form-label">Fuente de Contacto</label>
                                    <select class="form-select @error('source_id') is-invalid @enderror" 
                                            id="source_id" 
                                            name="source_id">
                                        <option value="">Seleccionar fuente</option>
                                        @foreach($sources as $source)
                                            <option value="{{ $source->id }}" 
                                                    {{ old('source_id', $opportunity->source_id) == $source->id ? 'selected' : '' }}>
                                                {{ $source->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('source_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="responsible_user_id" class="form-label">Usuario Responsable <span class="text-danger">*</span></label>
                                    <select class="form-select @error('responsible_user_id') is-invalid @enderror" 
                                            id="responsible_user_id" 
                                            name="responsible_user_id" 
                                            required>
                                        <option value="">Seleccionar usuario</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                    {{ old('responsible_user_id', $opportunity->responsible_user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('responsible_user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Campo para razón de pérdida (solo si es etapa de cierre perdida) -->
                        <div class="row" id="reason-lost-section" style="display: none;">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="reason_lost" class="form-label">Razón de Pérdida</label>
                                    <textarea class="form-control @error('reason_lost') is-invalid @enderror" 
                                              id="reason_lost" 
                                              name="reason_lost" 
                                              rows="3"
                                              placeholder="Explique por qué se perdió esta oportunidad...">{{ old('reason_lost', $opportunity->reason_lost) }}</textarea>
                                    @error('reason_lost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de auditoría -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Información:</strong> Esta oportunidad fue creada el {{ $opportunity->created_at->format('d/m/Y H:i') }}
                                    @if($opportunity->creator)
                                        por {{ $opportunity->creator->name }}
                                    @endif
                                    . Última actualización: {{ $opportunity->updated_at->format('d/m/Y H:i') }}.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Oportunidad
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos
    const stageSelect = document.getElementById('stage_id');
    const probabilityInput = document.getElementById('probability');
    const thirdSelect = document.getElementById('third_id');
    const contactNameInput = document.getElementById('contact_name');
    const contactEmailInput = document.getElementById('contact_email');
    const contactPhoneInput = document.getElementById('contact_phone');
    const reasonLostSection = document.getElementById('reason-lost-section');
    
    // Función para actualizar probabilidad basada en la etapa
    function updateProbabilityFromStage() {
        const selectedOption = stageSelect.options[stageSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.percentage) {
            const percentage = parseFloat(selectedOption.dataset.percentage);
            probabilityInput.value = percentage;
        }
    }
    
    // Función para mostrar/ocultar campo de razón de pérdida
    function toggleReasonLostField() {
        const selectedOption = stageSelect.options[stageSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.isClosing === 'true') {
            const percentage = parseFloat(selectedOption.dataset.percentage);
            if (percentage === 0) {
                reasonLostSection.style.display = 'block';
                document.getElementById('reason_lost').required = true;
            } else {
                reasonLostSection.style.display = 'none';
                document.getElementById('reason_lost').required = false;
            }
        } else {
            reasonLostSection.style.display = 'none';
            document.getElementById('reason_lost').required = false;
        }
    }
    
    // Función para llenar datos de contacto desde tercero
    function fillContactFromThird() {
        const selectedOption = thirdSelect.options[thirdSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            if (selectedOption.dataset.name && !contactNameInput.value) {
                contactNameInput.value = selectedOption.dataset.name;
            }
            if (selectedOption.dataset.email && !contactEmailInput.value) {
                contactEmailInput.value = selectedOption.dataset.email;
            }
            if (selectedOption.dataset.phone && !contactPhoneInput.value) {
                contactPhoneInput.value = selectedOption.dataset.phone;
            }
        }
    }
    
    // Event listeners
    stageSelect.addEventListener('change', function() {
        updateProbabilityFromStage();
        toggleReasonLostField();
    });
    
    thirdSelect.addEventListener('change', fillContactFromThird);
    
    // Validación del formulario
    document.getElementById('opportunityForm').addEventListener('submit', function(e) {
        const probability = parseFloat(probabilityInput.value);
        const estimatedValue = parseFloat(document.getElementById('estimated_value').value);
        
        if (probability < 0 || probability > 100) {
            e.preventDefault();
            alert('La probabilidad debe estar entre 0 y 100');
            return false;
        }
        
        if (estimatedValue < 0) {
            e.preventDefault();
            alert('El valor estimado debe ser mayor o igual a 0');
            return false;
        }
        
        // Validar fecha de cierre estimada
        const closingDate = document.getElementById('estimated_closing_date').value;
        if (closingDate) {
            const today = new Date();
            const selectedDate = new Date(closingDate);
            
            if (selectedDate < today.setHours(0,0,0,0)) {
                if (!confirm('La fecha de cierre estimada es anterior a hoy. ¿Desea continuar?')) {
                    e.preventDefault();
                    return false;
                }
            }
        }
        
        // Validar razón de pérdida si es requerida
        const reasonLostInput = document.getElementById('reason_lost');
        if (reasonLostInput.required && !reasonLostInput.value.trim()) {
            e.preventDefault();
            alert('Debe proporcionar una razón para la pérdida de esta oportunidad');
            reasonLostInput.focus();
            return false;
        }
    });
    
    // Inicializar estado de campos
    toggleReasonLostField();
    
    // Formatear valor estimado
    const estimatedValueInput = document.getElementById('estimated_value');
    estimatedValueInput.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
    
    // Auto-completar contacto si hay tercero seleccionado al cargar
    if (thirdSelect.value) {
        // No llenar automáticamente en edición para preservar datos existentes
    }
});
</script>
@endpush