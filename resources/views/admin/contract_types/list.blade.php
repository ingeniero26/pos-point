@extends('layouts.app')

    @section('content')
    <main class="app-main"> 
        <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tipo de Contrato</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tipo de Contrato
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
                                <h3 class="card-title">Listado de Tipos de Contrato</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-end">
                                        <button type="button" class="btn btn-sm btn-primary"
                                         data-bs-toggle="modal" data-bs-target="#contractTypeModal">
                                            Agregar Tipo de Contrato    
                                        </button>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="contract-types-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Código</th>
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
    <div class="modal fade" id="contractTypeModal" tabindex="-1" aria-labelledby="contractTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contractTypeModalLabel">Agregar Tipo de Contrato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="contractTypeForm" method="POST">
                        @csrf
                        <div class="row">
                         
                            <div class="col-md-6 mb-3">
                                <label for="contractTypeName">Nombre</label>
                                <input type="text" id="contractTypeName" name="name" class="form-control" maxlength="255" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contractTypeCode">Código</label>
                                <input type="text" id="contractTypeCode" name="code" class="form-control" maxlength="50" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contractTypeStatus">Estado</label>
                                <select id="contractTypeStatus" name="status" class="form-select" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
          
    @endsection
   @section('script')
   
   <script type="text/javascript">
    $(document).ready(function () {
        const tableSelector = '#contract-types-table';
        const modalElement = document.getElementById('contractTypeModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        const form = $('#contractTypeForm');
        let editingId = null;

        function escapeHtml(value) {
            return $('<div>').text(value == null ? '' : value).html();
        }

        function showRequestError(xhr, fallbackMessage) {
            let message = xhr.responseJSON && xhr.responseJSON.message
                ? xhr.responseJSON.message
                : fallbackMessage;
            const errors = xhr.responseJSON && xhr.responseJSON.errors;

            if (errors) {
                message = Object.values(errors).flat().join('<br>');
            }

            Swal.fire('Error', message, 'error');
        }

        function fetchContractTypes() {
            $.ajax({
                url: "{{ route('admin.contract_types.fetch') }}",
                type: 'GET',
                success: function (contractTypes) {
                    if ($.fn.DataTable.isDataTable(tableSelector)) {
                        $(tableSelector).DataTable().clear().destroy();
                    }

                    let tableBody = '';
                    $.each(contractTypes, function (index, contractType) {
                        const status = Number(contractType.status) === 1;
                        const createdAt = contractType.created_at
                            ? dayjs(contractType.created_at).format('DD/MM/YYYY h:mm A')
                            : '';
                        const updatedAt = contractType.updated_at
                            ? dayjs(contractType.updated_at).format('DD/MM/YYYY h:mm A')
                            : '';
                        const toggleText = status ? 'Desactivar' : 'Activar';
                        const toggleIcon = status ? 'fa-toggle-on' : 'fa-toggle-off';

                        tableBody += `<tr>
                            <td>${contractType.id}</td>
                            <td>${escapeHtml(contractType.name)}</td>
                            <td>${escapeHtml(contractType.code)}</td>
                            <td>${status ? 'Activo' : 'Inactivo'}</td>
                            <td>${createdAt}</td>
                            <td>${updatedAt}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm edit-btn" data-id="${contractType.id}" aria-label="Editar">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${contractType.id}" aria-label="Eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm toggle-status-btn" data-id="${contractType.id}" data-status="${status ? 1 : 0}">
                                    <i class="fa ${toggleIcon}"></i> ${toggleText}
                                </button>
                            </td>
                        </tr>`;
                    });

                    $(`${tableSelector} tbody`).html(tableBody);
                    $(tableSelector).DataTable();
                },
                error: function (xhr) {
                    showRequestError(xhr, 'No fue posible cargar los tipos de contrato.');
                }
            });
        }

        function resetForm() {
            editingId = null;
            form[0].reset();
            $('#contractTypeStatus').val('1');
            $('#contractTypeModalLabel').text('Agregar Tipo de Contrato');
            form.find('button[type="submit"]').text('Agregar');
        }

        $('#contractTypeModal').on('hidden.bs.modal', resetForm);

        form.on('submit', function (event) {
            event.preventDefault();
            const url = editingId
                ? "{{ url('admin/contract_types/update') }}/" + editingId
                : "{{ route('admin.contract_types.store') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    modal.hide();
                    resetForm();
                    $('.flashMessage').text(response.success).fadeIn().delay(3000).fadeOut();
                    fetchContractTypes();
                },
                error: function (xhr) {
                    showRequestError(xhr, 'No fue posible guardar el tipo de contrato.');
                }
            });
        });

        $(tableSelector).on('click', '.edit-btn', function () {
            const id = $(this).data('id');

            $.ajax({
                url: "{{ url('admin/contract_types/edit') }}/" + id,
                type: 'GET',
                success: function (contractType) {
                    editingId = contractType.id;
                    $('#contractTypeName').val(contractType.name);
                    $('#contractTypeCode').val(contractType.code);
                    $('#contractTypeStatus').val(String(Number(contractType.status)));
                    $('#contractTypeModalLabel').text('Editar Tipo de Contrato');
                    form.find('button[type="submit"]').text('Guardar cambios');
                    modal.show();
                },
                error: function (xhr) {
                    showRequestError(xhr, 'No fue posible cargar el tipo de contrato.');
                }
            });
        });

        $(tableSelector).on('click', '.delete-btn', function () {
            const id = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'El tipo de contrato dejará de aparecer en el listado.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    url: "{{ url('admin/contract_types/delete') }}/" + id,
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        Swal.fire('Eliminado', response.success, 'success');
                        fetchContractTypes();
                    },
                    error: function (xhr) {
                        showRequestError(xhr, 'No fue posible eliminar el tipo de contrato.');
                    }
                });
            });
        });

        $(tableSelector).on('click', '.toggle-status-btn', function () {
            const id = $(this).data('id');

            $.ajax({
                url: "{{ url('admin/contract_types/toggle-status') }}/" + id,
                type: 'PUT',
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) {
                    $('.flashMessage').text(response.success).fadeIn().delay(3000).fadeOut();
                    fetchContractTypes();
                },
                error: function (xhr) {
                    showRequestError(xhr, 'No fue posible actualizar el estado.');
                }
            });
        });

        fetchContractTypes();
    });
   </script>


@endsection


                                        
   