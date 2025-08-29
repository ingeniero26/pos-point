@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus mr-2"></i>
                        Nuevo Comprobante Contable
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('accounting-movements.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <form action="{{ route('accounting-movements.store') }}" method="POST" id="movementForm">
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

                        <!-- Información del Comprobante -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="receipt_type_id">Tipo de Comprobante <span class="text-danger">*</span></label>
                                    <select name="receipt_type_id" id="receipt_type_id" 
                                            class="form-control @error('receipt_type_id') is-invalid @enderror" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach($receiptTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('receipt_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('receipt_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="receipt_number">Número <span class="text-danger">*</span></label>
                                    <input type="text" name="receipt_number" id="receipt_number" 
                                           class="form-control @error('receipt_number') is-invalid @enderror"
                                           value="{{ old('receipt_number') }}" maxlength="20" required>
                                    @error('receipt_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="receipt_date">Fecha <span class="text-danger">*</span></label>
                                    <input type="date" name="receipt_date" id="receipt_date" 
                                           class="form-control @error('receipt_date') is-invalid @enderror"
                                           value="{{ old('receipt_date', date('Y-m-d')) }}" required>
                                    @error('receipt_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="due_date">Fecha de Vencimiento</label>
                                    <input type="date" name="due_date" id="due_date" 
                                           class="form-control @error('due_date') is-invalid @enderror"
                                           value="{{ old('due_date') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="concept">Concepto <span class="text-danger">*</span></label>
                                    <input type="text" name="concept" id="concept" 
                                           class="form-control @error('concept') is-invalid @enderror"
                                           value="{{ old('concept') }}" maxlength="255" required>
                                    @error('concept')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reference">Referencia</label>
                                    <input type="text" name="reference" id="reference" 
                                           class="form-control @error('reference') is-invalid @enderror"
                                           value="{{ old('reference') }}" maxlength="100">
                                    @error('reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if(Auth::user()->is_role == 1)
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="company_id">Empresa</label>
                                        <select name="company_id" id="company_id" 
                                                class="form-control @error('company_id') is-invalid @enderror">
                                            <option value="">Seleccionar...</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
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

                        <!-- Detalles del Comprobante -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Detalles del Comprobante</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="detailsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="20%">Cuenta PUC</th>
                                                <th width="25%">Concepto</th>
                                                <th width="12%">Débito</th>
                                                <th width="12%">Crédito</th>
                                                <th width="15%">Tercero</th>
                                                <th width="12%">Centro Costo</th>
                                                <th width="4%">
                                                    <button type="button" class="btn btn-success btn-sm" id="addDetail">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailsBody">
                                            <!-- Details will be added here -->
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-info">
                                                <th colspan="2">TOTALES</th>
                                                <th id="totalDebits">0.00</th>
                                                <th id="totalCredits">0.00</th>
                                                <th colspan="2">
                                                    <span id="balanceStatus" class="badge badge-warning">Desbalanceado</span>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <i class="fas fa-save"></i> Guardar Comprobante
                        </button>
                        <a href="{{ route('accounting-movements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Template for detail row -->
<template id="detailRowTemplate">
    <tr class="detail-row">
        <td>
            <select name="details[INDEX][puc_account_id]" class="form-control puc-account-select" required>
                <option value="">Seleccionar cuenta...</option>
                @foreach($pucAccounts as $account)
                    <option value="{{ $account->id }}" data-nature="{{ $account->nature }}">
                        {{ $account->account_code }} - {{ $account->account_code }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="details[INDEX][concept]" class="form-control" maxlength="255" required>
        </td>
        <td>
            <input type="number" name="details[INDEX][debit_amount]" class="form-control debit-input" 
                   step="0.01" min="0" placeholder="0.00">
        </td>
        <td>
            <input type="number" name="details[INDEX][credit_amount]" class="form-control credit-input" 
                   step="0.01" min="0" placeholder="0.00">
        </td>
        <td>
            <select name="details[INDEX][third_party_id]" class="form-control">
                <option value="">Sin tercero</option>
                @foreach($thirdParties as $party)
                    <option value="{{ $party->id }}">{{ $party->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="details[INDEX][cost_center_id]" class="form-control">
                <option value="">Sin centro</option>
                @foreach($costCenters as $center)
                    <option value="{{ $center->id }}">{{ $center->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-detail">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let detailIndex = 0;
    
    // Add initial rows
    addDetailRow();
    addDetailRow();
    
    // Add detail row
    document.getElementById('addDetail').addEventListener('click', function() {
        addDetailRow();
    });
    
    // Remove detail row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-detail')) {
            e.target.closest('.detail-row').remove();
            updateTotals();
        }
    });
    
    // Update totals when amounts change
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('debit-input') || e.target.classList.contains('credit-input')) {
            // Clear the opposite field
            const row = e.target.closest('tr');
            if (e.target.classList.contains('debit-input') && e.target.value) {
                row.querySelector('.credit-input').value = '';
            } else if (e.target.classList.contains('credit-input') && e.target.value) {
                row.querySelector('.debit-input').value = '';
            }
            updateTotals();
        }
    });
    
    // Auto-suggest amount based on account nature
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('puc-account-select')) {
            const selectedOption = e.target.selectedOptions[0];
            const nature = selectedOption.dataset.nature;
            const row = e.target.closest('tr');
            
            // Focus on appropriate field based on nature
            if (nature === 'DEBIT') {
                row.querySelector('.debit-input').focus();
            } else if (nature === 'CREDIT') {
                row.querySelector('.credit-input').focus();
            }
        }
    });
    
    function addDetailRow() {
        const template = document.getElementById('detailRowTemplate');
        const clone = template.content.cloneNode(true);
        
        // Replace INDEX with actual index
        clone.innerHTML = clone.innerHTML.replace(/INDEX/g, detailIndex);
        
        document.getElementById('detailsBody').appendChild(clone);
        detailIndex++;
        updateTotals();
    }
    
    function updateTotals() {
        let totalDebits = 0;
        let totalCredits = 0;
        
        document.querySelectorAll('.debit-input').forEach(input => {
            totalDebits += parseFloat(input.value) || 0;
        });
        
        document.querySelectorAll('.credit-input').forEach(input => {
            totalCredits += parseFloat(input.value) || 0;
        });
        
        document.getElementById('totalDebits').textContent = totalDebits.toFixed(2);
        document.getElementById('totalCredits').textContent = totalCredits.toFixed(2);
        
        const difference = Math.abs(totalDebits - totalCredits);
        const balanceStatus = document.getElementById('balanceStatus');
        const saveBtn = document.getElementById('saveBtn');
        
        if (difference < 0.01) {
            balanceStatus.textContent = 'Balanceado';
            balanceStatus.className = 'badge badge-success';
            saveBtn.disabled = false;
        } else {
            balanceStatus.textContent = 'Desbalanceado (' + difference.toFixed(2) + ')';
            balanceStatus.className = 'badge badge-warning';
            saveBtn.disabled = false; // Allow saving unbalanced for validation
        }
    }
});
</script>
@endsection