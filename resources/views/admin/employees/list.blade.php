@extends('layouts.app')

@section('style')
    <style>
        .employees-page {
            --employees-ink: #172b4d;
            --employees-muted: #70809a;
            --employees-line: #e8edf4;
            color: var(--employees-ink);
        }

        .employees-page .app-content-header {
            padding-bottom: .75rem;
        }

        .employees-page .page-eyebrow {
            color: #6178a5;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .employees-page .page-title {
            color: var(--employees-ink);
            font-size: clamp(1.5rem, 2.5vw, 2rem);
            font-weight: 700;
            letter-spacing: -.03em;
        }

        .employees-page .page-description {
            color: var(--employees-muted);
            max-width: 620px;
        }

        .employees-page .employee-hero {
            background: linear-gradient(115deg, #172b4d 0%, #264b7a 100%);
            border: 0;
            border-radius: 1rem;
            color: #fff;
            overflow: hidden;
            position: relative;
        }

        .employees-page .employee-hero::after {
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
            content: "";
            height: 260px;
            position: absolute;
            right: -65px;
            top: -135px;
            width: 260px;
        }

        .employees-page .employee-hero .card-body {
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .employees-page .hero-icon {
            align-items: center;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 1rem;
            display: inline-flex;
            font-size: 1.4rem;
            height: 3.25rem;
            justify-content: center;
            width: 3.25rem;
        }

        .employees-page .hero-copy {
            color: rgba(255, 255, 255, .76);
        }

        .employees-page .hero-refresh {
            border-color: rgba(255, 255, 255, .45);
            color: #fff;
        }

        .employees-page .hero-refresh:hover {
            background: #fff;
            color: #203c62;
        }

        .employees-page .employee-stat {
            border: 1px solid var(--employees-line);
            border-radius: .9rem;
            height: 100%;
        }

        .employees-page .stat-icon {
            align-items: center;
            background: #eef3fb;
            border-radius: .8rem;
            color: #426493;
            display: inline-flex;
            font-size: 1.1rem;
            height: 2.75rem;
            justify-content: center;
            width: 2.75rem;
        }

        .employees-page .stat-icon.is-active {
            background: #e8f7ef;
            color: #198754;
        }

        .employees-page .stat-icon.is-inactive {
            background: #fff4e5;
            color: #b66a08;
        }

        .employees-page .stat-value {
            color: var(--employees-ink);
            font-size: 1.65rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .employees-page .stat-label {
            color: var(--employees-muted);
            font-size: .85rem;
        }

        .employees-page .directory-card {
            border: 1px solid var(--employees-line);
            border-radius: 1rem;
            overflow: hidden;
        }

        .employees-page .directory-card > .card-header {
            background: #fff;
            border-bottom: 1px solid var(--employees-line);
            padding: 1.1rem 1.25rem;
        }

        .employees-page .directory-card > .card-body {
            padding: 1.25rem;
        }

        .employees-page .directory-subtitle {
            color: var(--employees-muted);
            font-size: .875rem;
        }

        .employees-page .search-control {
            max-width: 360px;
        }

        .employees-page .search-control .input-group-text {
            background: #fff;
            border-right: 0;
            color: #8794a8;
        }

        .employees-page .search-control .form-control {
            border-left: 0;
        }

        .employees-page .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .employees-page .table thead th {
            background: #f8fafd;
            border-bottom: 1px solid var(--employees-line);
            color: #71809a;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            padding: .9rem 1rem;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .employees-page .table tbody td {
            border-color: #eef1f6;
            color: #40516c;
            padding: .95rem 1rem;
        }

        .employees-page .employee-identity {
            align-items: center;
            display: flex;
            gap: .8rem;
            min-width: 230px;
        }

        .employees-page .employee-avatar {
            align-items: center;
            background: #edf2fa;
            border-radius: 50%;
            color: #375b8a;
            display: inline-flex;
            flex: 0 0 2.6rem;
            font-size: .78rem;
            font-weight: 700;
            height: 2.6rem;
            justify-content: center;
            width: 2.6rem;
        }

        .employees-page .employee-name {
            color: var(--employees-ink);
            font-weight: 600;
        }

        .employees-page .employee-meta {
            color: var(--employees-muted);
            font-size: .8rem;
            margin-top: .15rem;
        }

        .employees-page .employee-contact {
            min-width: 190px;
        }

        .employees-page .contact-line + .contact-line {
            margin-top: .25rem;
        }

        .employees-page .contact-line i {
            color: #8b99ad;
            margin-right: .35rem;
            width: .9rem;
        }

        .employees-page .status-badge {
            border-radius: 2rem;
            display: inline-block;
            font-size: .75rem;
            font-weight: 600;
            padding: .35rem .65rem;
        }

        .employees-page .status-badge.is-active {
            background: #e8f7ef;
            color: #198754;
        }

        .employees-page .status-badge.is-inactive {
            background: #fff4e5;
            color: #a85e00;
        }

        .employees-page .table-message {
            color: var(--employees-muted);
            padding: 3rem 1rem !important;
            text-align: center;
        }

        .employees-page .table-message i {
            color: #9aa8bc;
            display: block;
            font-size: 1.7rem;
            margin-bottom: .7rem;
        }

        .employees-page .load-error {
            align-items: center;
            background: #fff5f5;
            border: 1px solid #f3d0d0;
            border-radius: .75rem;
            color: #842029;
            display: flex;
            gap: .75rem;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding: .85rem 1rem;
        }

        @media (max-width: 575.98px) {
            .employees-page .employee-hero .card-body,
            .employees-page .directory-card > .card-body {
                padding: 1rem;
            }

            .employees-page .hero-refresh {
                margin-top: 1rem;
                width: 100%;
            }

            .employees-page .search-control {
                max-width: none;
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <main class="app-main employees-page">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-end g-3">
                    <div class="col-lg-8">
                        <div class="page-eyebrow mb-2">Equipo de trabajo</div>
                        <h1 class="page-title mb-2">Empleados</h1>
                        <p class="page-description mb-0">Consulta y encuentra fácilmente la información de las personas vinculadas a tu equipo.</p>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-lg-end mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Empleados</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content-body pb-4">
            <div class="container-fluid">
                <section class="card employee-hero shadow-sm mb-4" aria-label="Directorio de empleados">
                    <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="hero-icon" aria-hidden="true"><i class="bi bi-people"></i></span>
                            <div>
                                <h2 class="h5 fw-semibold mb-1">Directorio del equipo</h2>
                                <p class="hero-copy mb-0">Información centralizada para una consulta rápida y sencilla.</p>
                            </div>
                        </div>
                        <button type="button" class="btn hero-refresh" id="refreshEmployees">
                            <i class="bi bi-arrow-clockwise me-1" aria-hidden="true"></i>
                            Actualizar listado
                        </button>
                    </div>
                </section>

                <div class="row g-3 mb-4" aria-live="polite">
                    <div class="col-sm-4">
                        <div class="card employee-stat shadow-sm">
                            <div class="card-body d-flex align-items-center gap-3">
                                <span class="stat-icon" aria-hidden="true"><i class="bi bi-people"></i></span>
                                <div>
                                    <div class="stat-value" id="totalEmployees">—</div>
                                    <div class="stat-label">Total de empleados</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card employee-stat shadow-sm">
                            <div class="card-body d-flex align-items-center gap-3">
                                <span class="stat-icon is-active" aria-hidden="true"><i class="bi bi-person-check"></i></span>
                                <div>
                                    <div class="stat-value" id="activeEmployees">—</div>
                                    <div class="stat-label">Activos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card employee-stat shadow-sm">
                            <div class="card-body d-flex align-items-center gap-3">
                                <span class="stat-icon is-inactive" aria-hidden="true"><i class="bi bi-person-dash"></i></span>
                                <div>
                                    <div class="stat-value" id="inactiveEmployees">—</div>
                                    <div class="stat-label">Inactivos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="card directory-card shadow-sm">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h2 class="h5 fw-semibold mb-1">Listado de empleados</h2>
                            <p class="directory-subtitle mb-0" id="resultsSummary">Cargando información del equipo...</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="input-group search-control">
                                <span class="input-group-text"><i class="bi bi-search" aria-hidden="true"></i></span>
                                <input type="search" class="form-control" id="employeeSearch" placeholder="Buscar por nombre, documento o contacto" aria-label="Buscar empleados" disabled>
                            </div>
                            <select class="form-select" id="employeeStatusFilter" aria-label="Filtrar por estado" disabled>
                                <option value="all">Todos los estados</option>
                                <option value="active">Activos</option>
                                <option value="inactive">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="load-error" id="employeesError" role="alert" hidden>
                            <span><i class="bi bi-exclamation-circle me-2" aria-hidden="true"></i><span id="employeesErrorMessage">No fue posible cargar la información.</span></span>
                            <button type="button" class="btn btn-sm btn-outline-danger" id="retryEmployees">Reintentar</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Empleado</th>
                                        <th scope="col">Contacto</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Fecha de registro</th>
                                    </tr>
                                </thead>
                                <tbody id="employeesTableBody">
                                    <tr>
                                        <td colspan="4" class="table-message">
                                            <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
                                            Consultando empleados...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const endpoint = @json(route('admin.employees.fetch'));
            const tableBody = document.getElementById('employeesTableBody');
            const searchInput = document.getElementById('employeeSearch');
            const statusFilter = document.getElementById('employeeStatusFilter');
            const refreshButton = document.getElementById('refreshEmployees');
            const retryButton = document.getElementById('retryEmployees');
            const errorPanel = document.getElementById('employeesError');
            const errorMessage = document.getElementById('employeesErrorMessage');
            const resultsSummary = document.getElementById('resultsSummary');
            const numberFormatter = new Intl.NumberFormat('es-CO');
            let employees = [];

            function makeElement(tagName, className, text) {
                const element = document.createElement(tagName);
                if (className) {
                    element.className = className;
                }
                if (text !== undefined) {
                    element.textContent = text;
                }
                return element;
            }

            function employeeName(employee) {
                const name = [
                    employee.first_name,
                    employee.second_name,
                    employee.last_name,
                    employee.second_last_name
                ].filter(function (part) {
                    return typeof part === 'string' && part.trim() !== '';
                }).join(' ').trim();

                return name || employee.name_trade || employee.company_name || 'Nombre no disponible';
            }

            function isActive(employee) {
                return employee.status === true || employee.status === 1 || employee.status === '1';
            }

            function formatDate(value) {
                if (!value) {
                    return '—';
                }

                const date = new Date(value);
                if (Number.isNaN(date.getTime())) {
                    return '—';
                }

                return new Intl.DateTimeFormat('es-CO', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).format(date);
            }

            function initials(name) {
                return name.split(/\s+/).filter(Boolean).slice(0, 2).map(function (part) {
                    return part.charAt(0);
                }).join('').toLocaleUpperCase('es-CO') || 'EM';
            }

            function showMessage(icon, message) {
                const row = makeElement('tr');
                const cell = makeElement('td', 'table-message');
                cell.colSpan = 4;
                cell.appendChild(makeElement('i', 'bi ' + icon));
                cell.appendChild(document.createTextNode(message));
                row.appendChild(cell);
                tableBody.replaceChildren(row);
            }

            function appendContact(cell, icon, value) {
                if (!value) {
                    return;
                }

                const line = makeElement('div', 'contact-line');
                const iconElement = makeElement('i', 'bi ' + icon);
                iconElement.setAttribute('aria-hidden', 'true');
                line.appendChild(iconElement);
                line.appendChild(document.createTextNode(value));
                cell.appendChild(line);
            }

            function renderEmployees() {
                const query = searchInput.value.trim().toLocaleLowerCase('es-CO');
                const selectedStatus = statusFilter.value;
                const filteredEmployees = employees.filter(function (employee) {
                    const active = isActive(employee);
                    const matchesStatus = selectedStatus === 'all'
                        || (selectedStatus === 'active' && active)
                        || (selectedStatus === 'inactive' && !active);
                    const searchableText = [
                        employeeName(employee),
                        employee.identification_number,
                        employee.phone,
                        employee.email
                    ].filter(Boolean).join(' ').toLocaleLowerCase('es-CO');

                    return matchesStatus && searchableText.includes(query);
                });

                resultsSummary.textContent = filteredEmployees.length === employees.length
                    ? numberFormatter.format(employees.length) + (employees.length === 1 ? ' empleado encontrado' : ' empleados encontrados')
                    : numberFormatter.format(filteredEmployees.length) + ' de ' + numberFormatter.format(employees.length) + ' empleados';

                if (filteredEmployees.length === 0) {
                    showMessage('bi-search', employees.length ? 'No hay empleados que coincidan con la búsqueda.' : 'Aún no hay empleados registrados.');
                    return;
                }

                const rows = document.createDocumentFragment();
                filteredEmployees.forEach(function (employee) {
                    const name = employeeName(employee);
                    const active = isActive(employee);
                    const row = makeElement('tr');
                    const identityCell = makeElement('td');
                    const identity = makeElement('div', 'employee-identity');
                    const avatar = makeElement('span', 'employee-avatar', initials(name));
                    avatar.setAttribute('aria-hidden', 'true');
                    const identityText = makeElement('div');
                    identityText.appendChild(makeElement('div', 'employee-name', name));
                    identityText.appendChild(makeElement(
                        'div',
                        'employee-meta',
                        employee.identification_number ? 'Documento · ' + employee.identification_number : 'Documento no registrado'
                    ));
                    identity.appendChild(avatar);
                    identity.appendChild(identityText);
                    identityCell.appendChild(identity);

                    const contactCell = makeElement('td', 'employee-contact');
                    appendContact(contactCell, 'bi-telephone', employee.phone);
                    appendContact(contactCell, 'bi-envelope', employee.email);
                    if (!employee.phone && !employee.email) {
                        contactCell.appendChild(makeElement('span', 'employee-meta', 'Sin datos de contacto'));
                    }

                    const statusCell = makeElement('td');
                    statusCell.appendChild(makeElement(
                        'span',
                        'status-badge ' + (active ? 'is-active' : 'is-inactive'),
                        active ? 'Activo' : 'Inactivo'
                    ));

                    const dateCell = makeElement('td', '', formatDate(employee.created_at));
                    row.appendChild(identityCell);
                    row.appendChild(contactCell);
                    row.appendChild(statusCell);
                    row.appendChild(dateCell);
                    rows.appendChild(row);
                });

                tableBody.replaceChildren(rows);
            }

            async function loadEmployees() {
                refreshButton.disabled = true;
                refreshButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Actualizando...';
                errorPanel.hidden = true;
                showMessage('bi-arrow-repeat', 'Consultando empleados...');

                try {
                    const response = await fetch(endpoint, {
                        headers: { Accept: 'application/json' }
                    });

                    if (!response.ok) {
                        throw new Error('El servidor respondió con el estado ' + response.status + '.');
                    }

                    const data = await response.json();
                    if (!Array.isArray(data)) {
                        throw new Error('El servidor devolvió un formato de datos inesperado.');
                    }

                    employees = data;
                    document.getElementById('totalEmployees').textContent = numberFormatter.format(employees.length);
                    document.getElementById('activeEmployees').textContent = numberFormatter.format(employees.filter(isActive).length);
                    document.getElementById('inactiveEmployees').textContent = numberFormatter.format(employees.filter(function (employee) {
                        return !isActive(employee);
                    }).length);
                    searchInput.disabled = false;
                    statusFilter.disabled = false;
                    renderEmployees();
                } catch (error) {
                    console.error('No fue posible cargar los empleados:', error);
                    errorMessage.textContent = 'No fue posible cargar los empleados. ' + error.message;
                    errorPanel.hidden = false;
                    resultsSummary.textContent = 'No se pudo consultar la información del equipo.';
                    showMessage('bi-exclamation-circle', 'Verifica tu conexión e inténtalo de nuevo.');
                } finally {
                    refreshButton.disabled = false;
                    refreshButton.innerHTML = '<i class="bi bi-arrow-clockwise me-1" aria-hidden="true"></i>Actualizar listado';
                }
            }

            searchInput.addEventListener('input', renderEmployees);
            statusFilter.addEventListener('change', renderEmployees);
            refreshButton.addEventListener('click', loadEmployees);
            retryButton.addEventListener('click', loadEmployees);
            loadEmployees();
        });
    </script>
@endsection
