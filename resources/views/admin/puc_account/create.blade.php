@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Cuenta PUC
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('puc-accounts.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <form action="{{ route('puc-accounts.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Información Básica -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_code">Código de Cuenta <span class="text-danger">*</span></label>
                                    <input type="text" name="account_code" id="account_code" 
                                           class="form-control @error('account_code') is-invalid @enderror"
                                           value="{{ old('account_code') }}" maxlength="10" required>
                                    @error('account_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_name">Nombre de la Cuenta <span class="text-danger">*</span></label>
                                    <input type="text" name="account_name" id="account_name" 
                                           class="form-control @error('account_name') is-invalid @enderror"
                                           value="{{ old('account_name') }}" maxlength="255" required>
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="level">Nivel <span class="text-danger">*</span></label>
                                    <select name="level" id="level" 
                                            class="form-control @error('level') is-invalid @enderror" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="1" {{ old('level') == '1' ? 'selected' : '' }}>1 - Clase</option>
                                        <option value="2" {{ old('level') == '2' ? 'selected' : '' }}>2 - Grupo</option>
                                        <option value="3" {{ old('level') == '3' ? 'selected' : '' }}>3 - Cuenta</option>
                                        <option value="4" {{ old('level') == '4' ? 'selected' : '' }}>4 - Subcuenta</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parent_code">Cuenta Padre</label>
                                    <select name="parent_code" id="parent_code" 
                                            class="form-control @error('parent_code') is-invalid @enderror">
                                        <option value="">Sin cuenta padre</option>
                                        @foreach($parentAccounts as $parent)
                                            <option value="{{ $parent->account_code }}" 
                                                    {{ old('parent_code') == $parent->account_code ? 'selected' : '' }}>
                                                {{ $parent->account_code }} - {{ $parent->account_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if(Auth::user()->is_role == 3)
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="company_id">Empresa</label>
                                        <select name="company_id" id="company_id" 
                                                class="form-control @error('company_id') is-invalid @enderror">
                                            <option value="">Todas las empresas</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" 
                                                        {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_type">Tipo de Cuenta <span class="text-danger">*</span></label>
                                    <select name="account_type" id="account_type" 
                                            class="form-control @error('account_type') is-invalid @enderror" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="ASSETS" {{ old('account_type') == 'ASSETS' ? 'selected' : '' }}>Activos</option>
                                        <option value="LIABILITIES" {{ old('account_type') == 'LIABILITIES' ? 'selected' : '' }}>Pasivos</option>
                                        <option value="EQUITY" {{ old('account_type') == 'EQUITY' ? 'selected' : '' }}>Patrimonio</option>
                                        <option value="INCOME" {{ old('account_type') == 'INCOME' ? 'selected' : '' }}>Ingresos</option>
                                        <option value="EXPENSES" {{ old('account_type') == 'EXPENSES' ? 'selected' : '' }}>Gastos</option>
                                        <option value="COST" {{ old('account_type') == 'COST' ? 'selected' : '' }}>Costos</option>
                                    </select>
                                    @error('account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nature">Naturaleza <span class="text-danger">*</span></label>
                                    <select name="nature" id="nature" 
                                            class="form-control @error('nature') is-invalid @enderror" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="DEBIT" {{ old('nature') == 'DEBIT' ? 'selected' : '' }}>Débito</option>
                                        <option value="CREDIT" {{ old('nature') == 'CREDIT' ? 'selected' : '' }}>Crédito</option>
                                    </select>
                                    @error('nature')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Configuraciones -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Configuraciones de la Cuenta</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="third_party_handling" id="third_party_handling" 
                                               class="custom-control-input" value="1" 
                                               {{ old('third_party_handling') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="third_party_handling">
                                            Manejo de Terceros
                                        </label>
                                    </div>
                                    <small class="text-muted">Permite asociar terceros a los movimientos</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="cost_center_handling" id="cost_center_handling" 
                                               class="custom-control-input" value="1" 
                                               {{ old('cost_center_handling') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="cost_center_handling">
                                            Manejo de Centro de Costos
                                        </label>
                                    </div>
                                    <small class="text-muted">Permite asociar centros de costo</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="accept_movement" id="accept_movement" 
                                               class="custom-control-input" value="1" 
                                               {{ old('accept_movement', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="accept_movement">
                                            Acepta Movimientos
                                        </label>
                                    </div>
                                    <small class="text-muted">Permite registrar movimientos contables</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Cuenta
                        </button>
                        <a href="{{ route('puc-accounts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const accountTypeSelect = document.getElementById('account_type');
    const natureSelect = document.getElementById('nature');
    
    // Auto-suggest nature based on account type
    accountTypeSelect.addEventListener('change', function() {
        const accountType = this.value;
        
        // Clear current selection
        natureSelect.value = '';
        
        // Suggest nature based on account type
        if (accountType === 'ASSETS' || accountType === 'EXPENSES' || accountType === 'COST') {
            natureSelect.value = 'DEBIT';
        } else if (accountType === 'LIABILITIES' || accountType === 'EQUITY' || accountType === 'INCOME') {
            natureSelect.value = 'CREDIT';
        }
    });
});
</script>
@endsection