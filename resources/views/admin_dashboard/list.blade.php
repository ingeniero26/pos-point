@extends('layouts.app')
  
@section('content')
       
<main class="app-main"> 
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard Administrador
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content"> 
        <div class="container-fluid"> 
            <!-- Filtros de fecha -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Filtros de Fecha</h5>
                        </div>
                        <div class="card-body">
                            <form id="filterForm" class="row g-3">
                                <div class="col-md-4">
                                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-search"></i> Filtrar
                                        </button>
                                        <button type="button" id="debugBtn" class="btn btn-secondary">
                                            <i class="fas fa-bug"></i> Debug
                                        </button>
                                        <button type="button" id="resetBtn" class="btn btn-outline-secondary">
                                            <i class="fas fa-refresh"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Debug info -->
            <div class="row mb-4" id="debugInfo" style="display: none;">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle"></i> Información de Debug
                            </h5>
                            <button type="button" class="btn-close" id="closeDebug"></button>
                        </div>
                        <hr>
                        <pre id="debugContent" style="max-height: 300px; overflow-y: auto;"></pre>
                    </div>
                </div>
            </div>

            <!-- Status bar -->
            <div class="row mb-4" id="statusBar" style="display: none;">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span id="statusMessage">Cargando datos...</span>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de totales -->
            <div class="row"> 
                <div class="col-lg-6 col-6"> 
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3 id="total_ventas">$0.00</h3>
                            <p>Total Ventas</p>
                            <small id="ventas_info" class="text-light opacity-75"></small>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                        </svg>
                    </div> 
                </div>
                <div class="col-lg-6 col-6"> 
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3 id="total_por_pagar">$0.00</h3>
                            <p>Cuentas x Pagar</p>
                            <small id="cuentas_pagar_info" class="text-light opacity-75"></small>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                        </svg>
                    </div> 
                </div>
                <div class="col-lg-6 col-6">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3 id="total_por_cobrar">$0.00</h3>
                            <p>Cuentas x Cobrar</p>
                            <small id="cuentas_cobrar_info" class="text-light opacity-75"></small>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                        </svg>
                    </div> 
                </div>
                <div class="col-lg-6 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3 id="total_compras">$0.00</h3>
                            <p>Total Compras</p>
                            <small id="compras_info" class="text-light opacity-75"></small>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                        </svg>
                    </div> 
                </div>
            </div>

            <!-- Gráfico de ventas vs compras -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line"></i> Ventas vs Compras
                            </h3>
                            <div class="card-tools">
                                <span id="chart_period" class="badge badge-info"></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart_loading" class="text-center py-5" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <p class="mt-2">Cargando gráfico...</p>
                            </div>
                            <canvas id="ventasComprasChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Resumen del Período</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="border-end">
                                        <div class="text-center">
                                            <h4 id="diferencia_valor" class="mb-1">$0.00</h4>
                                            <p class="text-muted mb-0">Diferencia</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <h4 id="promedio_diario" class="mb-1">$0.00</h4>
                                        <p class="text-muted mb-0">Promedio Diario</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Estado del Sistema</h5>
                        </div>
                        <div class="card-body">
                            <div id="system_status">
                                <p><i class="fas fa-database text-success"></i> Base de datos: <span id="db_status">Conectada</span></p>
                                <p><i class="fas fa-table text-info"></i> Registros totales: <span id="total_records">-</span></p>
                                <p><i class="fas fa-calendar text-warning"></i> Último filtro: <span id="last_filter">-</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
   
   <script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    let ventasComprasChart = null;
    let currentData = null;

    // Inicializar el gráfico
    function initChart() {
        const ctx = document.getElementById('ventasComprasChart');
        if (!ctx) {
            console.error('No se encontró el elemento canvas para el gráfico');
            return;
        }

        // Destruir el gráfico existente si existe
        if (ventasComprasChart) {
            ventasComprasChart.destroy();
        }

        ventasComprasChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Ventas',
                        data: [],
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Compras',
                        data: [],
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.1,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + new Intl.NumberFormat('es-ES').format(value);
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': $' + new Intl.NumberFormat('es-ES').format(context.raw);
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    }

    // Función para actualizar el gráfico con nuevos datos
    function updateChart(data) {
        if (!ventasComprasChart) {
            initChart();
        }

        ventasComprasChart.data.labels = data.fechas || [];
        ventasComprasChart.data.datasets[0].data = data.ventas || [];
        ventasComprasChart.data.datasets[1].data = data.compras || [];
        ventasComprasChart.update();
    }

    // Función para cargar los datos
    function cargarDatos(fechaInicio, fechaFin) {
        console.log('🔄 Cargando datos para:', fechaInicio, 'hasta', fechaFin);
        
        // Mostrar indicadores de carga
        document.getElementById('total_ventas').textContent = 'Cargando...';
        document.getElementById('total_compras').textContent = 'Cargando...';
        document.getElementById('total_por_pagar').textContent = 'Cargando...';
        document.getElementById('total_por_cobrar').textContent = 'Cargando...';
        document.getElementById('ventas_info').textContent = '';
        document.getElementById('compras_info').textContent = '';
        document.getElementById('cuentas_cobrar_info').textContent = '';
        document.getElementById('cuentas_pagar_info').textContent = '';
        
        toggleLoading(true);
        showStatus('Cargando datos del dashboard...', 'info');

        const url = `{{ url('admin/dashboard/totales') }}?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`;
        console.log('🌐 URL de petición:', url);

        fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('📡 Respuesta recibida:', response.status, response.statusText);
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('📊 Datos recibidos:', data);
            currentData = data;
            
            if (data.error) {
                throw new Error(data.message || 'Error al obtener los datos');
            }

            // Actualizar totales
            document.getElementById('total_ventas').textContent = `$${formatearNumero(data.total_ventas)}`;
            document.getElementById('total_compras').textContent = `$${formatearNumero(data.total_compras)}`;
            document.getElementById('total_por_pagar').textContent = `$${formatearNumero(data.cuentas_por_pagar)}`;
            document.getElementById('total_por_cobrar').textContent = `$${formatearNumero(data.cuentas_por_cobrar)}`;

            
            // Agregar información adicional
            document.getElementById('ventas_info').textContent = `${data.ventas ? data.ventas.filter(v => v > 0).length : 0} días con ventas`;
            document.getElementById('compras_info').textContent = `${data.compras ? data.compras.filter(c => c > 0).length : 0} días con compras`;
           // document.getElementById('cuentas_cobrar_info').textContent = `${data.cuentas_por_cobrar ? data.cuentas_por_cobrar.filter(c => c > 0).length : 0} días con cuentas por cobrar`;
           // document.getElementById('cuentas_pagar_info').textContent = `${data.cuentas_por_pagar ? data.cuentas_por_pagar.filter(c => c > 0).length : 0} días con cuentas por pagar`;

            
            // Actualizar el gráfico
            updateChart(data);

            // Actualizar información adicional
            updateAdditionalInfo(data);

            toggleLoading(false);
            showStatus('Datos cargados correctamente', 'success');
        })
        .catch(error => {
            console.error('❌ Error completo:', error);
            document.getElementById('total_ventas').textContent = 'Error';
            document.getElementById('total_compras').textContent = 'Error';
            document.getElementById('ventas_info').textContent = 'Error al cargar';
            document.getElementById('compras_info').textContent = 'Error al cargar';
            document.getElementById('total_por_pagar').textContent = 'Error';
            
            toggleLoading(false);
            showStatus('Error al cargar los datos: ' + error.message, 'danger');
        });
    }

    // Inicializar el gráfico al cargar la página
    initChart();

    // Configurar el formulario de filtros
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            if (fechaInicio && fechaFin) {
                cargarDatos(fechaInicio, fechaFin);
            }
        });
    }

    // Configurar el botón de debug
    const debugBtn = document.getElementById('debugBtn');
    if (debugBtn) {
        debugBtn.addEventListener('click', function() {
            const debugInfo = document.getElementById('debugInfo');
            const debugContent = document.getElementById('debugContent');
            if (debugInfo && debugContent) {
                debugInfo.style.display = debugInfo.style.display === 'none' ? 'block' : 'none';
                if (currentData) {
                    debugContent.textContent = JSON.stringify(currentData, null, 2);
                }
            }
        });
    }

    // Configurar el botón de reset
    const resetBtn = document.getElementById('resetBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            filterForm.reset();
            if (currentData) {
                cargarDatos(currentData.fecha_inicio, currentData.fecha_fin);
            }
        });
    }

    // Mostrar/ocultar indicador de carga
    function toggleLoading(show) {
        const loadingElement = document.getElementById('chart_loading');
        const chartElement = document.getElementById('ventasComprasChart');
        
        if (show) {
            loadingElement.style.display = 'block';
            chartElement.style.display = 'none';
        } else {
            loadingElement.style.display = 'none';
            chartElement.style.display = 'block';
        }
    }

    // Mostrar mensajes de estado
    function showStatus(message, type = 'info') {
        const statusBar = document.getElementById('statusBar');
        const statusMessage = document.getElementById('statusMessage');
        const alertDiv = statusBar.querySelector('.alert');
        
        // Cambiar clase de alerta
        alertDiv.className = `alert alert-${type}`;
        statusMessage.textContent = message;
        statusBar.style.display = 'block';
        
        // Auto-ocultar después de 5 segundos para mensajes de éxito
        if (type === 'success') {
            setTimeout(() => {
                statusBar.style.display = 'none';
            }, 5000);
        }
    }

    // Formatear números
    function formatearNumero(numero) {
        return new Intl.NumberFormat('es-ES', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(numero);
    }

    // Actualizar información adicional
    function updateAdditionalInfo(data) {
        if (data.total_ventas !== undefined && data.total_compras !== undefined) {
            const diferencia = data.total_ventas - data.total_compras;
            const totalDias = data.fechas ? data.fechas.length : 1;
            const promedioDiario = (data.total_ventas + data.total_compras) / totalDias / 2;
            
            document.getElementById('diferencia_valor').textContent = `$${formatearNumero(diferencia)}`;
            document.getElementById('promedio_diario').textContent = `$${formatearNumero(promedioDiario)}`;
            
            // Cambiar color según la diferencia
            const diferenciaElement = document.getElementById('diferencia_valor');
            if (diferencia > 0) {
                diferenciaElement.className = 'mb-1 text-success';
            } else if (diferencia < 0) {
                diferenciaElement.className = 'mb-1 text-danger';
            } else {
                diferenciaElement.className = 'mb-1 text-muted';
            }
        }

        // Actualizar información del sistema
        if (data.debug) {
            const totalRecords = (data.debug.total_registros_ventas || 0) + (data.debug.total_registros_compras || 0);
            document.getElementById('total_records').textContent = totalRecords.toLocaleString();
        }

        // Actualizar período del gráfico
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;
        if (fechaInicio && fechaFin) {
            document.getElementById('chart_period').textContent = `${fechaInicio} al ${fechaFin}`;
            document.getElementById('last_filter').textContent = new Date().toLocaleString();
        }
    }
});
</script>

       
@endsection
   