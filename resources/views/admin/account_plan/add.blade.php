@extends('layouts.app')
  
@section('content')
<main class="app-main">
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Nueva Cuenta</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/account_plan/list')}}">Cuenta</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Nueva Cuenta
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content-body">
        <div class="container-fluid">
            <form id="accountPlanForm" method="POST" action="{{ url('admin/account_plan/store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account_plan_name">Código de la Cuenta</label>
                                            <input type="text" class="form-control" id="code" name="code"
                                             placeholder="Código de la Cuenta" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account_plan_name">Nombre de la Cuenta</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                             placeholder="Nombre de la Cuenta" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account_plan_name">Nombre Completo</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name"
                                             placeholder="Nombre de la Cuenta" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_account">Cuenta Padre</label>
                                            <select class="form-select" id="parent_id" name="parent_id" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($accountParents as $account)
                                                    <option value="{{ $account->id }}">{{ $account->code}}-{{ $account->name }}</option>
                                                @endforeach
                                            </select>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Level">Nivel</label>
                                            <select name="level" class="form-select" id="level">
                                                <option value="">Seleccione...</option>
                                              
                                                <option value="1">Clase</option>
                                                <option value="2">Grupo</option>
                                                <option value="3">Cuenta</option>
                                                <option value="4">Subcuenta</option>
                                                <option value="5">Auxiliar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nature">Naturaleza</label>
                                            <select name="nature" class="form-select" id="nature">
                                                <option value="">Seleccione...</option>
                                                <option value="Debit">Débito</option>
                                                <option value="Credit">Crédito</option>
                                               
                                               

                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Level">Tipo de Cuenta</label>
                                            <select name="account_type" class="form-select" id="account_type">
                                                <option value="">Seleccione...</option>
                                                <option value="Assets">Activo</option>
                                                <option value="Liabilities">Pasivo</option>
                                                <option value="Equity">Patrimonio</option>
                                                <option value="Income">Ingreso</option>
                                                <option value="Expense">Egreso</option>
                                                <option value="Cost">Costo</option>
                                                <option value="Order">Orden</option>
                                                <option value="Control">Control</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="movement">Movimiento</label>
                                            <select class="form-select" id="movement" name="movement" required>
                                               
                                                <option value="Yes">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="adjustment">Ajuste</label>
                                            <select class="form-select" id="adjustment" name="adjustment" required>
                                               
                                                <option value="No">No</option>
                                                <option value="Yes">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="third_parties">Tercero</label>
                                            <select class="form-select" id="third_parties" name="third_parties">
                                               
                                                <option value="No">No</option>
                                                <option value="Yes">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cost_center">Centro de Costo</label>
                                            <select class="form-select" id="cost_center" name="cost_center" >
                                               
                                                <option value="No">No</option>
                                                <option value="Yes">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="taxable_base">Base Gravable</label>
                                            <select class="form-select" id="taxable_base" name="taxable_base" >
                                              
                                                <option value="No">No</option>
                                                <option value="Yes">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="withholding">Retención</label>
                                            <select class="form-select" id="withholding" name="withholding" >
                                               
                                                <option value="None">No</option>
                                                <option value="ReteFuente">Rete Fuente</option>
                                                <option value="ReteIVA">Rete IVA</option>
                                                <option value="ReteICA">Rete ICA</option>
                                                <option value="ReteCREE">Rete CREE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="third_parties">Tercero</label>
                                            <select class="form-select" id="third_parties" name="third_parties">
                                             
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                               
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="withholding_rate">Tarifa</label>
                                            <input type="text" class="form-control" id="withholding_rate" name="withholding_rate"
                                             placeholder="Tarifa">                                            
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exogenous">Exógeno</label>
                                            <select class="form-select" id="exogenous" name="exogenous" >
                                             
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="code_exogenous">Código Exógeno</label>
                                            <input type="text" class="form-control" id="code_exogenous" name="code_exogenous"
                                             placeholder="Código Exógeno">
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="depreciation">Depreciación</label>
                                            <select class="form-select" id="depreciation" name="depreciation" >
                                               
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="amortization">Amortización</label>
                                            <select class="form-select" id="amortization" name="amortization" >
                                             
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exhaustion">Agotamiento</label>
                                            <select class="form-select" id="exhaustion" name="exhaustion" >
                                             
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-primary" id="saveAccountPlan">
                                            <i class="fas fa-save"></i> Guardar
                                        </button>
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
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#saveAccountPlan').click(function() {
        // Mostrar indicador de carga
        $('.loading-overlay').show();

        // Obtener los datos del formulario
        let formData = {
            code: $('#code').val(),
            name: $('#name').val(),
            full_name: $('#full_name').val(),
            parent_id: $('#parent_id').val(),
            nature: $('#nature').val(),
            level: $('#level').val(),
            account_type: $('#account_type').val(),
            movement: $('#movement').val(),
            adjustment: $('#adjustment').val(),
            third_parties: $('#third_parties').val(),
            cost_center: $('#cost_center').val(),
            taxable_base: $('#taxable_base').val(),
            withholding: $('#withholding').val(),
            withholding_rate: $('#withholding_rate').val(),
            exogenous: $('#exogenous').val(),
            code_exogenous: $('#code_exogenous').val(),
            depreciation: $('#depreciation').val(),
            amortization: $('#amortization').val(),
            exhaustion: $('#exhaustion').val()
        };

        // Enviar petición AJAX
        $.ajax({
            url: "{{ route('admin.account_plan.store') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Ocultar indicador de carga
                $('.loading-overlay').hide();

                if (response.success) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Cuenta guardada correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Redirigir a la lista de cuentas
                        window.location.href = "{{ route('admin.account_plan.list') }}";
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Error al guardar la cuenta'
                    });
                }
            },
            error: function(xhr) {
                // Ocultar indicador de carga
                $('.loading-overlay').hide();

                // Manejar errores de validación
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '<ul>';
                    
                    for (let field in errors) {
                        errorMessage += `<li>${errors[field][0]}</li>`;
                    }
                    errorMessage += '</ul>';

                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Validación',
                        html: errorMessage
                    });
                } else {
                    // Mostrar error general
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ha ocurrido un error al guardar la cuenta'
                    });
                }
            }
        });
    });
});
</script>
@endsection