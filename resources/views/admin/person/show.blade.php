@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detalles del Tercero</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/person/list')}}">Terceros</a></li>
                        <li class="breadcrumb-item active">Detalles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Información del Tercero</h3>
                            <div class="card-tools">
                                <a href="{{ url('admin/person') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5>Información Básica</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 30%">Tipo de Tercero</th>
                                                <td>{{ $person->type_third ? $person->type_third->type_third : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tipo de Documento</th>
                                                <td>{{ $person->identification_type ? $person->identification_type->identification_name : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Número de Identificación</th>
                                                <td>{{ $person->identification_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nombre de la Empresa</th>
                                                <td>{{ $person->company_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nombre</th>
                                                <td>{{ $person->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Apellido</th>
                                                <td>{{ $person->last_name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5>Información Tributaria</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 30%">Tipo de Persona</th>
                                                <td>{{ $person->type_person ? $person->type_person->type_person : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tipo de Régimen</th>
                                                <td>{{ $person->type_regimen ? $person->type_regimen->regimen_name : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tipo de Obligación</th>
                                                <td>{{ $person->type_liability ? $person->type_liability->liability_name : 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h5>Información de Contacto</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 15%">País</th>
                                                <td>{{ $person->countries ? $person->countries->country_name : 'N/A' }}</td>
                                                <th style="width: 15%">Departamento</th>
                                                <td>{{ $person->departments ? $person->departments->name_department : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ciudad</th>
                                                <td>{{ $person->cities ? $person->cities->city_name : 'N/A' }}</td>
                                                <th>Dirección</th>
                                                <td>{{ $person->address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Teléfono</th>
                                                <td>{{ $person->phone }}</td>
                                                <th>Correo Electrónico</th>
                                                <td>{{ $person->email }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @if($person->comment)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h5>Comentarios</h5>
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $person->comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h5>Información del Sistema</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 15%">Estado</th>
                                                <td>
                                                    @if($person->status == 0)
                                                        <span class="badge bg-success">Activo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                                <th style="width: 15%">Fecha de Creación</th>
                                                <td>{{ $person->created_at->format('d/m/Y H:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Última Actualización</th>
                                                <td colspan="3">{{ $person->updated_at->format('d/m/Y H:i A') }}</td>
                                            </tr>
                                        </table>
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
