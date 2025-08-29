@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ventas por Categoría</h3>
                    
                    <div class="card-tools">
                        <form class="form-inline" method="GET">
                            <div class="form-group mx-2">
                                <label for="start_date" class="mr-2">Desde:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="form-group mx-2">
                                <label for="end_date" class="mr-2">Hasta:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                    value="{{ request('end_date') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($salesData) > 0)
                        <canvas id="salesChart" style="min-height: 400px;"></canvas>
                    @else
                        <div class="alert alert-info">
                            No hay datos de ventas para mostrar en el período seleccionado.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if(count($salesData) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesData);
    
    // Procesar datos para el gráfico
    const categories = [...new Set(salesData.map(item => item.category_name))];
    const dates = [...new Set(salesData.map(item => item.sale_date))];
    
    const datasets = categories.map(category => {
        const data = dates.map(date => {
            const sale = salesData.find(s => s.category_name === category && s.sale_date === date);
            return sale ? sale.total_quantity : 0;
        });
        
        return {
            label: category,
            data: data,
            backgroundColor: getRandomColor(),
        };
    });

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dates,
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad Vendida'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Ventas por Categoría'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});

function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
</script>
@endif
@endsection