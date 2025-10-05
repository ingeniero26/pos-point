@extends('layouts.app')

@section('title', 'Editar Etapa de Oportunidad')

@section('content')
<main class="app-main"> 
    <div class="app-content-header"> 
        <h1 class="app-content-headerText">Editar Etapa de Oportunidad</h1> 
        <div class="app-content-headerButton">
            <a href="{{ route('opportunity-stages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Etapas
            </a>
        </div>
    </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Editar Etapa de Oportunidad</h3>
                    <div class="btn-group">
                        <a href="{{ route('opportunity-stages.show', $opportunityStage) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="{{ route('opportunity-stages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('opportunity-stages.update', $opportunityStage) }}" method="POST" id="stageForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $opportunityStage->name) }}" 
                                           required
                                           maxlength="255">
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
                                            <option value="{{ $company->id }}" 
                                                {{ old('company_id', $opportunityStage->company_id) == $company->id ? 'selected' : '' }}>
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
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3"
                                              maxlength="1000">{{ old('description', $opportunityStage->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Máximo 1000 caracteres</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="closing_percentage" class="form-label">Porcentaje de Cierre <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control @error('closing_percentage') is-invalid @enderror" 
                                               id="closing_percentage" 
                                               name="closing_percentage" 
                                               value="{{ old('closing_percentage', $opportunityStage->closing_percentage) }}" 
                                               min="0" 
                                               max="100" 
                                               step="0.01"
                                               required>
                                        <span class="input-group-text">%</span>
                                        @error('closing_percentage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Valor entre 0 y 100</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="colour" class="form-label">Color</label>
                                    <div class="input-group">
                                        <input type="color" 
                                               class="form-control form-control-color @error('colour') is-invalid @enderror" 
                                               id="colour" 
                                               name="colour" 
                                               value="{{ old('colour', $opportunityStage->colour ?? '#007bff') }}"
                                               style="width: 60px;">
                                        <input type="text" 
                                               class="form-control" 
                                               id="colour_text" 
                                               value="{{ old('colour', $opportunityStage->colour ?? '#007bff') }}"
                                               readonly>
                                        @error('colour')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Color para identificar la etapa</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Opciones</label>
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_closing_stage" 
                                               name="is_closing_stage"
                                               {{ old('is_closing_stage', $opportunityStage->is_closing_stage) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_closing_stage">
                                            Es etapa de cierre
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="status" 
                                               name="status"
                                               {{ old('status', $opportunityStage->status) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">
                                            Activo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Información:</strong> Esta etapa fue creada el {{ $opportunityStage->created_at->format('d/m/Y H:i') }}
                                    @if($opportunityStage->creator)
                                        por {{ $opportunityStage->creator->name }}
                                    @endif
                                    y tiene el orden {{ $opportunityStage->order }}.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('opportunity-stages.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Etapa
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
</main>
@endsection

@section('script')
<script script="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Sincronizar color picker con input de texto
    const colorPicker = document.getElementById('colour');
    const colorText = document.getElementById('colour_text');
    
    colorPicker.addEventListener('input', function() {
        colorText.value = this.value;
    });
    
    colorText.addEventListener('input', function() {
        if (this.value.match(/^#[0-9A-F]{6}$/i)) {
            colorPicker.value = this.value;
        }
    });
    
    // Validación del formulario
    document.getElementById('stageForm').addEventListener('submit', function(e) {
        const percentage = parseFloat(document.getElementById('closing_percentage').value);
        
        if (percentage < 0 || percentage > 100) {
            e.preventDefault();
            alert('El porcentaje de cierre debe estar entre 0 y 100');
            return false;
        }
    });
    
    // Auto-ajustar porcentaje si es etapa de cierre
    document.getElementById('is_closing_stage').addEventListener('change', function() {
        const percentageInput = document.getElementById('closing_percentage');
        if (this.checked && parseFloat(percentageInput.value) < 100) {
            if (confirm('¿Desea establecer el porcentaje de cierre en 100% para esta etapa de cierre?')) {
                percentageInput.value = 100;
            }
        }
    });
});
</script>
@endsection