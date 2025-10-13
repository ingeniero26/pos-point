@extends('layouts.app')

@section('title', 'Crear Oportunidad')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Crear Nueva Oportunidad</h3>
                    <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('opportunities.store') }}" method="POST" id="opportunityForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Información General</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nombre de la Oportunidad <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('name') is-invalid @enderror" 
                                                           id="name" 
                                                           name="name" 
                                                           value="{{ old('name') }}" 
                                                           required
                                                           maxlength="200">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="company_id" class="form-label">Compañía <span class="text-danger">*</span></label>
                                                    <select class="form-select @error('company_id') is-invalid @enderror" 
                                                            id="company_id" 
                                                            name="company_id" 
                                                            required>
                                                        <option value="">Seleccionar compañía</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                                {{ $company->company_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('company_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Descripción</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                                              id="description" 
                                                              name="description" 
                                                              rows="3"
                                                              maxlength="500">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-text">Máximo 500 caracteres</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Información de Contacto</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="third_id" class="form-label">Cliente/Tercero</label>
                                                    <select class="form-select @error('third_id') is-invalid @enderror" 
                                                            id="third_id" 
                                                            name="third_id">
                                                        <option value="">Seleccionar cliente</option>
                                                        @foreach($contacts as $contact)
                                                            <option value="{{ $contact->id }}" {{ old('third_id') == $contact->id ? 'selected' : '' }}>
                                                                {{ $contact->first_name }}
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
                                                           value="{{ old('contact_name') }}" 
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
                                                           value="{{ old('contact_email') }}"
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
                                                           value="{{ old('contact_phone') }}"
                                                           maxlength="500">
                                                    @error('contact_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Configuración</h5>
                                    </div>
                                    <div class="card-body">
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
                                                            {{ old('stage_id') == $stage->id ? 'selected' : '' }}>
                                                        {{ $stage->name }} ({{ $stage->closing_percentage }}%)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('stage_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="source_id" class="form-label">Fuente</label>
                                            <select class="form-select @error('source_id') is-invalid @enderror" 
                                                    id="source_id" 
                                                    name="source_id">
                                                <option value="">Seleccionar fuente</option>
                                                @foreach($sources as $source)
                                                    <option value="{{ $source->id }}" {{ old('source_id') == $source->id ? 'selected' : '' }}>
                                                        {{ $source->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('source_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="responsible_user_id" class="form-label">Responsable <span class="text-danger">*</span></label>
                                            <select class="form-select @error('responsible_user_id') is-invalid @enderror" 
                                                    id="responsible_user_id" 
                                                    name="responsible_user_id" 
                                                    required>
                                                <option value="">Seleccionar responsable</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ old('responsible_user_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('responsible_user_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="estimated_value" class="form-label">Valor Estimado <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" 
                                                       class="form-control @error('estimated_value') is-invalid @enderror" 
                                                       id="estimated_value" 
                                                       name="estimated_value" 
                                                       value="{{ old('estimated_value', 0) }}" 
                                                       min="0" 
                                                       step="0.01"
                                                       required>
                                                @error('estimated_value')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="probability" class="form-label">Probabilidad <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" 
                                                       class="form-control @error('probability') is-invalid @enderror" 
                                                       id="probability" 
                                                       name="probability" 
                                                       value="{{ old('probability', 0) }}" 
                                                       min="0" 
                                                       max="100" 
                                                       step="0.01"
                                                       required>
                                                <span class="input-group-text">%</span>
                                                @error('probability')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="estimated_closing_date" class="form-label">Fecha Estimada de Cierre</label>
                                            <input type="date" 
                                                   class="form-control @error('estimated_closing_date') is-invalid @enderror" 
                                                   id="estimated_closing_date" 
                                                   name="estimated_closing_date" 
                                                   value="{{ old('estimated_closing_date') }}"
                                                   min="{{ date('Y-m-d') }}">
                                            @error('estimated_closing_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Guardar Oportunidad
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
    // Auto-completar probabilidad basada en la etapa seleccionada
    const stageSelect = document.getElementById('stage_id');
    const probabilityInput = document.getElementById('probability');
    
    stageSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.dataset.percentage) {
            probabilityInput.value = selectedOption.dataset.percentage;
        }
    });
    
    // Auto-completar información de contacto cuando se selecciona un tercero
    const thirdSelect = document.getElementById('third_id');
    const contactNameInput = document.getElementById('contact_name');
    
    thirdSelect.addEventListener('change', function() {
        if (this.value) {
            // Aquí podrías hacer una llamada AJAX para obtener los datos del tercero
            // Por ahora, solo copiamos el nombre
            const selectedOption = this.options[this.selectedIndex];
            if (contactNameInput.value === '') {
                contactNameInput.value = selectedOption.text;
            }
        }
    });
    
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
    });
});
</script>
@endpush