@extends('layouts.app')
  
    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tipo de Cuenta</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tipo de Cuenta
                            </li>
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
                                <h3 class="card-title">Listado de Tipos de Cuentas Contables</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <a href="" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#addAccountChartTypeModal">
                                            Agregar Tipo de Cuenta Contable
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="entity_bank-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tipo de Código</th>
                                                <th>Tipo de Cuenta</th>
                                                <th>Descripción</th>
                                                <th>Saldo Cuenta</th>
                                                 <th>Tipo Cuenta Padre</th>
                                                 <th>Sección Balance</th>
                                                 <th>Sección Estado de R.</th>
                                                 <th>Estado Aparece</th>
                                                 <th>Nivel</th>
                                                 <th>Permite Movimiento</th>
                                                 <th>Requiere Detalle</th>
                                                 <th>Orden</th>
                                                 <th>Estado</th>
                                                 <th>Creado</th>
                                                 <th>Actualizado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main> 
    {{-- modal crear  --}}
    <div class="flashMessage alert alert-success" style="display: none;"></div>
    <div class="modal fade" id="addAccountChartTypeModal" tabindex="-1" aria-labelledby="addAccountChartTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountChartTypeModalLabel">Agregar Tipo de Cuenta Contable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAccountChartTypeForm">
                        {{ @csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="type_code" class="form-label"><b>Código*</b></label>
                                    <input type="text" class="form-control" id="type_code" name="type_code" placeholder="1, 2, 3..." required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="type_name" class="form-label"><b>Nombre*</b></label>
                                    <input type="text" class="form-control" id="type_name" name="type_name" placeholder="Activo, Pasivo..." required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="normal_balance" class="form-label"><b>Saldo Normal*</b></label>
                                    <select class="form-select" id="normal_balance" name="normal_balance" required>
                                        <option value="">Seleccione</option>
                                        <option value="D">Débito</option>
                                        <option value="C">Crédito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="level" class="form-label"><b>Nivel*</b></label>
                                    <select class="form-select" id="level" name="level" required>
                                        <option value="">Seleccione</option>
                                        <option value="1">1 - Clase</option>
                                        <option value="2">2 - Grupo</option>
                                        <option value="3">3 - Subgrupo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="type_description" class="form-label"><b>Descripción</b></label>
                                    <textarea class="form-control" id="type_description" name="type_description" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="balance_sheet_section" class="form-label"><b>Sección Balance General</b></label>
                                    <input type="text" class="form-control" id="balance_sheet_section" name="balance_sheet_section" placeholder="Activo Circulante, Pasivo...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="income_statement_section" class="form-label"><b>Sección Estado Resultados</b></label>
                                    <input type="text" class="form-control" id="income_statement_section" name="income_statement_section" placeholder="Operacional, No Operacional...">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="statement_type" class="form-label"><b>Aparece En</b></label>
                                    <select class="form-select" id="statement_type" name="statement_type">
                                        <option value="both" selected>Ambos Reportes</option>
                                        <option value="balance_sheet">Solo Balance</option>
                                        <option value="income_statement">Solo Estado Resultados</option>
                                        <option value="none">Ninguno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_movement" name="is_movement" value="1" checked>
                                        <label class="form-check-label" for="is_movement">
                                            Permite Movimiento
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="requires_detail" name="requires_detail" value="1">
                                        <label class="form-check-label" for="requires_detail">
                                            Requiere Detalle
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label"><b>Orden</b></label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="parent_type_id" class="form-label"><b>Tipo Padre</b></label>
                                    <select class="form-select" id="parent_type_id" name="parent_type_id">
                                        <option value="">Ninguno (Raíz)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                                        <label class="form-check-label" for="status">
                                            Activo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </main>
    @endsection
    @section('script')
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            var table = $('#entity_bank-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.account_chart_types.fetch') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'type_code', name: 'type_code' },
                    { data: 'type_name', name: 'type_name' },
                    { data: 'type_description', name: 'type_description' },
                    { data: 'normal_balance', name: 'normal_balance' },
                    { data: 'parent_account_type', name: 'parent_account_type' },
                    { data: 'balance_sheet_section', name: 'balance_sheet_section' },
                    { data: 'income_statement_section', name: 'income_statement_section' },
                    { data: 'appears_in_report', name: 'appears_in_report' },
                    { data: 'level', name: 'level' },
                    { data: 'allows_movement', name: 'allows_movement' },
                    { data: 'requires_detail', name: 'requires_detail' },
                    { data: 'sort_order', name: 'sort_order' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });

            // Cargar tipos padres cuando se abre el modal
            $('#addAccountChartTypeModal').on('show.bs.modal', function() {
                $.ajax({
                    url: "{{ route('admin.account_chart_types.parent-types') }}",
                    method: "GET",
                    success: function(response) {
                        var parentSelect = $('#parent_type_id');
                        parentSelect.empty();
                        parentSelect.append('<option value="">Ninguno (Raíz)</option>');
                        
                        response.forEach(function(item) {
                            parentSelect.append('<option value="' + item.id + '">' + item.type_code + ' - ' + item.type_name + '</option>');
                        });
                    }
                });
            });

            // Manejar envío del formulario de creación
            $('#addAccountChartTypeForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('admin.account_chart_types.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#addAccountChartTypeModal').modal('hide');
                            $('#addAccountChartTypeForm')[0].reset();
                            table.ajax.reload();
                            $('.flashMessage')
                                .removeClass('alert-danger')
                                .addClass('alert-success')
                                .text(response.message)
                                .show()
                                .delay(3000)
                                .fadeOut();
                        }
                    },
                    error: function(response) {
                        var errorMessage = 'Error al crear el tipo de cuenta.';
                        if (response.responseJSON && response.responseJSON.message) {
                            errorMessage = response.responseJSON.message;
                        }
                        $('.flashMessage')
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .text(errorMessage)
                            .show()
                            .delay(5000)
                            .fadeOut();
                    }
                });
            });
        });
    </script>
    @endsection
