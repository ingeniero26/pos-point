@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Editar Información de la Empresa</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Editar Empresa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="busines_type_id" class="form-label">Tipo de Empresa</label>
                                        <select class="form-select @error('busines_type_id') is-invalid @enderror" name="busines_type_id" id="busines_type_id">
                                            <option value="">Seleccione...</option>
                                            @foreach($businessTypes as $id => $name)
                                                <option value="{{ $id }}" {{ old('busines_type_id', $company->busines_type_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('busines_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="identification_type_id" class="form-label">Tipo de Identificación</label>
                                        <select class="form-select @error('identification_type_id') is-invalid @enderror" name="identification_type_id" id="identification_type_id">
                                            <option value="">Seleccione...</option>
                                            @foreach($identification_types as $id => $name)
                                                <option value="{{ $id }}" {{ old('identification_type_id', $company->identification_type_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('identification_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="identification_number" class="form-label">Número de Identificación</label>
                                        <input type="text" class="form-control @error('identification_number') is-invalid @enderror" id="identification_number" name="identification_number" value="{{ old('identification_number', $company->identification_number) }}">
                                        @error('identification_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="dv" class="form-label">Dígito de Verificación</label>
                                        <input type="text" class="form-control @error('dv') is-invalid @enderror" id="dv" name="dv" value="{{ old('dv', $company->dv) }}">
                                        @error('dv')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Nombre de la Empresa</label>
                                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $company->company_name) }}">
                                        @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Nombre Comercial</label>
                                        <input type="text" class="form-control @error('trade_name') is-invalid @enderror" id="trade_name" name="trade_name" value="{{ old('trade_name', $company->trade_name) }}">
                                        @error('trade_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="short_name" class="form-label">Nombre Corto</label>
                                        <input type="text" class="form-control @error('short_name') is-invalid @enderror" id="short_name" name="short_name" value="{{ old('short_name', $company->short_name) }}">
                                        @error('short_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Código CIIU</label>
                                        <input type="text" class="form-control @error('code_ciiu') is-invalid @enderror" id="code_ciiu" name="code_ciiu" value="{{ old('code_ciiu', $company->code_ciiu) }}">
                                        @error('code_ciiu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="activity_description" class="form-label">Descripción de la Actividad</label>
                                        <input type="text" class="form-control @error('activity_description') is-invalid @enderror" id="activity_description" name="activity_description" value="{{ old('activity_description', $company->activity_description) }}">
                                        @error('activity_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $company->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="legal_representative" class="form-label">Representante Legal</label>
                                        <input type="text" class="form-control @error('legal_representative') is-invalid @enderror" id="legal_representative" name="legal_representative" value="{{ old('legal_representative', $company->legal_representative) }}">
                                        @error('legal_representative')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="cc_representative" class="form-label">Cédula Representante Legal</label>
                                        <input type="text" class="form-control @error('cc_representative') is-invalid @enderror" id="cc_representative" name="cc_representative" value="{{ old('cc_representative', $company->cc_representative) }}">
                                        @error('cc_representative')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-3">
                                        <label for="logo" class="form-label">Logo</label>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($company->logo)
                                            <div class="mt-2">
                                                <img src="{{ asset($company->logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 100px">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="country_id" class="form-label">País</label>
                                        <select class="form-select @error('country_id') is-invalid @enderror" name="country_id" id="country_id">
                                            <option value="">Seleccione...</option>
                                            @foreach($countries as $id => $name)
                                                <option value="{{ $id }}" {{ old('country_id', $company->country_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="department_id" class="form-label">Departamento</label>
                                        <select class="form-select @error('department_id') is-invalid @enderror" name="department_id" id="department_id">
                                            <option value="">Seleccione...</option>
                                            @foreach($departments as $id => $name)
                                                <option value="{{ $id }}" {{ old('department_id', $company->department_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="city_id" class="form-label">Ciudad</label>
                                        <select class="form-select @error('city_id') is-invalid @enderror" name="city_id" id="city_id">
                                            <option value="">Seleccione...</option>
                                            @foreach($cities as $id => $name)
                                                <option value="{{ $id }}" {{ old('city_id', $company->city_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Dirección</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $company->address) }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $company->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="currency_id" class="form-label">Moneda</label>
                                        <select class="form-select @error('currency_id') is-invalid @enderror" name="currency_id" id="currency_id">
                                            <option value="">Seleccione...</option>
                                            @foreach($currencies as $id => $name)
                                                <option value="{{ $id }}" {{ old('currency_id', $company->currency_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('currency_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="type_regimen_id" class="form-label">Tipo de Régimen</label>
                                        <select class="form-select @error('type_regimen_id') is-invalid @enderror" name="type_regimen_id" id="type_regimen_id">
                                            <option value="">Seleccione...</option>
                                            @foreach($type_regimens as $id => $name)
                                                <option value="{{ $id }}" {{ old('type_regimen_id', $company->type_regimen_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type_regimen_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="economic_activity_code" class="form-label">Código de Actividad Económica</label>
                                        <input type="text" class="form-control @error('economic_activity_code') is-invalid @enderror" id="economic_activity_code" name="economic_activity_code" value="{{ old('economic_activity_code', $company->economic_activity_code) }}">
                                        @error('economic_activity_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="ica_rate" class="form-label">Tarifa ICA</label>
                                        <input type="text" class="form-control @error('ica_rate') is-invalid @enderror" id="ica_rate" name="ica_rate" value="{{ old('ica_rate', $company->ica_rate) }}">
                                        @error('ica_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="type_obligation_id" class="form-label">Tipo de Régimen</label>
                                        <select class="form-select @error('type_obligation_id') is-invalid @enderror" name="type_obligation_id" id="type_obligation_id">
                                            <option value="">Seleccione...</option>
                                            @foreach($type_obligation as $id => $name)
                                                <option value="{{ $id }}" {{ old('type_obligation_id', $company->type_obligation_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type_obligation_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h3 class="mt-4 text-center">DATOS DIAN</h3>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="dian_resolution" class="form-label">Resolución DIAN</label>
                                        <input type="text" class="form-control @error('dian_resolution') is-invalid @enderror" id="dian_resolution" name="dian_resolution" value="{{ old('dian_resolution', $company->dian_resolution) }}">
                                        @error('dian_resolution')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="invoice_prefix" class="form-label">Prefijo DIAN</label>
                                        <input type="text" class="form-control @error('invoice_prefix') is-invalid @enderror" id="invoice_prefix" name="invoice_prefix" value="{{ old('invoice_prefix', $company->invoice_prefix) }}">
                                        @error('invoice_prefix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label for="current_consecutive" class="form-label">Consecutivo DIAN</label>
                                        <input type="text" class="form-control @error('current_consecutive') is-invalid @enderror" id="dian_consecutive" name="dian_consecutive" value="{{ old('dian_consecutive', $company->dian_consecutive) }}">
                                        @error('current_consecutive')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label for="range_from" class="form-label">Rango Desde</label>
                                        <input type="text" class="form-control @error('range_from') is-invalid @enderror" id="range_from" name="range_from" value="{{ old('range_from', $company->range_from) }}">
                                        @error('range_from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label for="range_to" class="form-label">Rango Hasta</label>
                                        <input type="text" class="form-control @error('range_to') is-invalid @enderror" id="range_to" name="range_to" value="{{ old('range_to', $company->range_to) }}">
                                        @error('range_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                                <h3>Rangos de Fechas</h3>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="resolution_date" class="form-label">Resolución  DIAN</label>
                                        <input type="date" class="form-control @error('resolution_date') is-invalid @enderror" id="resolution_date" name="resolution_date" 
                                         value="{{ old('resolution_date', $company->resolution_date ? \Carbon\Carbon::parse($company->resolution_date)->format('Y-m-d') : '') }}">

                                        @error('resolution_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_from" class="form-label">Fecha Inicio  DIAN</label>
                                        <input type="date" class="form-control @error('date_from') is-invalid @enderror" id="date_from" name="date_from" 
                                         value="{{ old('date_from', $company->date_from ? \Carbon\Carbon::parse($company->date_from)->format('Y-m-d') : '') }}">

                                        @error('date_from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_to" class="form-label">Fecha Fin  DIAN</label>
                                        <input type="date" class="form-control @error('date_to') is-invalid @enderror" id="date_to" name="date_to" 
                                         value="{{ old('date_to', $company->date_to ? \Carbon\Carbon::parse($company->date_to)->format('Y-m-d') : '') }}">

                                        @error('date_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="environment" class="form-label">Ambiente</label>
                                        <input type="text" class="form-control @error('environment') is-invalid @enderror" id="environment" name="environment" disabled value="{{ old('environment', $company->environment) }}">
                                        @error('environment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Actualizar Información</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Actualizar departamentos cuando cambia el país
    $('#country_id').change(function() {
        let countryId = $(this).val();
        if(countryId) {
            $.ajax({
                url: '/admin/get-departments/' + countryId,
                type: 'GET',
                success: function(data) {
                    $('#department_id').empty();
                    $('#department_id').append('<option value="">Seleccione...</option>');
                    $.each(data, function(id, name) {
                        $('#department_id').append('<option value="' + id + '">' + name + '</option>');
                    });
                }
            });
        }
    });

    // Actualizar ciudades cuando cambia el departamento
    $('#department_id').change(function() {
        let departmentId = $(this).val();
        if(departmentId) {
            $.ajax({
                url: '/admin/get-cities/' + departmentId,
                type: 'GET',
                success: function(data) {
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Seleccione...</option>');
                    $.each(data, function(id, name) {
                        $('#city_id').append('<option value="' + id + '">' + name + '</option>');
                    });
                }
            });
        }
    });
});
</script>
@endsection