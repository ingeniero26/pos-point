<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\PurchaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        if(Auth::user()->is_role == 1)
        {
            return view('admin_dashboard.list');
        }
         else if(Auth::user()->is_role == 2)
         {
            return view('user_dashboard.list');
         }
         else if(Auth::user()->is_role == 3)
         {
            return view('super_admin_dashboard.list');
         }
         else
        {
            abort(403, 'No tiene permisos para acceder a este panel.');
        }
    }

    public function getTotales(Request $request)
    {
        try {
            // Validar fechas
            $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
            ]);

            $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
            $fechaFin = Carbon::parse($request->fecha_fin)->endOfDay();

            // Debug: Log las fechas
            Log::info('Dashboard - Fechas filtro:', [
                'inicio' => $fechaInicio->format('Y-m-d H:i:s'),
                'fin' => $fechaFin->format('Y-m-d H:i:s')
            ]);

            // Verificar si existen registros en las tablas
            $totalRegistrosVentas = Sales::count();
            $totalRegistrosCompras = PurchaseModel::count();
            
            
            Log::info('Dashboard - Total registros:', [
                'ventas' => $totalRegistrosVentas,
                'compras' => $totalRegistrosCompras
            ]);

            // Obtener totales con verificación adicional
            $totalVentas = Sales::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('total_sale') ?? 0;
                
            $totalCompras = PurchaseModel::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('total_purchase') ?? 0;

            // Debug: Log los totales
            Log::info('Dashboard - Totales calculados:', [
                'ventas' => $totalVentas,
                'compras' => $totalCompras
            ]);

            // Obtener datos para el gráfico con mejor manejo de fechas
            $ventasPorDia = Sales::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->select(
                    DB::raw('DATE(created_at) as fecha'), 
                    DB::raw('COALESCE(SUM(total_sale), 0) as total')
                )
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->get();

            $comprasPorDia = PurchaseModel::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->select(
                    DB::raw('DATE(created_at) as fecha'), 
                    DB::raw('COALESCE(SUM(total_purchase), 0) as total')
                )
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->get();

            // Debug: Log datos por día
            Log::info('Dashboard - Datos por día:', [
                'ventas_por_dia' => $ventasPorDia->toArray(),
                'compras_por_dia' => $comprasPorDia->toArray()
            ]);

            // Preparar datos para el gráfico
            $fechas = [];
            $ventas = [];
            $compras = [];

            $ventasPorDiaMap = $ventasPorDia->pluck('total', 'fecha')->toArray();
            $comprasPorDiaMap = $comprasPorDia->pluck('total', 'fecha')->toArray();

            // Generar todas las fechas en el rango
            $currentDate = $fechaInicio->copy();
            while ($currentDate <= $fechaFin) {
                $fechaStr = $currentDate->format('Y-m-d');
                $fechas[] = $currentDate->format('d/m/Y');
                $ventas[] = floatval($ventasPorDiaMap[$fechaStr] ?? 0);
                $compras[] = floatval($comprasPorDiaMap[$fechaStr] ?? 0);
                $currentDate->addDay();
            }

            // Calcular cuentas por pagar
            $cuentasPorPagar = \App\Models\AccountsPayableModel::where('account_statuses_id', '1')
                ->where('company_id', auth()->user()->company_id)
                ->where('is_delete', 0)
                ->whereRaw('balance > 0')
                ->sum('balance') ?? 0;

            // Calcular cuentas por cobrar
            $cuentasPorCobrar = \App\Models\AccountsReceivable::where('account_statuses_id', '1')
                ->where('company_id', auth()->user()->company_id)
                ->where('is_delete', 0)
                ->whereRaw('balance > 0')
                ->sum('balance') ?? 0;

            $response = [
                'success' => true,
                'total_ventas' => floatval($totalVentas),
                'total_compras' => floatval($totalCompras),
                'fechas' => $fechas,
                'ventas' => $ventas,
                'compras' => $compras,
                'cuentas_por_pagar' => floatval($cuentasPorPagar),
                'cuentas_por_cobrar' => floatval($cuentasPorCobrar),
                'debug' => [
                    'total_registros_ventas' => $totalRegistrosVentas,
                    'total_registros_compras' => $totalRegistrosCompras,
                    'fecha_inicio' => $fechaInicio->format('Y-m-d H:i:s'),
                    'fecha_fin' => $fechaFin->format('Y-m-d H:i:s'),
                    'rango_dias' => $fechaInicio->diffInDays($fechaFin) + 1
                ]
            ];

            Log::info('Dashboard - Respuesta final:', $response);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Dashboard - Error en getTotales: ' . $e->getMessage());
            Log::error('Dashboard - Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error' => true,
                'message' => 'Error al obtener los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método para testing y debugging de modelos
     */
    public function testModels()
    {
        try {
            // Verificar conexión a modelos
            $ventasTest = Sales::first();
            $comprasTest = PurchaseModel::first();
            
            // Verificar estructura de tablas
            $ventasColumns = DB::getSchemaBuilder()->getColumnListing('sales');
            $comprasColumns = DB::getSchemaBuilder()->getColumnListing('purchases'); // o el nombre real de tu tabla
            
            // Obtener registros recientes
            $ventasRecientes = Sales::latest()->take(3)->get();
            $comprasRecientes = PurchaseModel::latest()->take(3)->get();

            return response()->json([
                'conexion' => [
                    'ventas_existe' => $ventasTest ? true : false,
                    'compras_existe' => $comprasTest ? true : false,
                ],
                'contadores' => [
                    'ventas_count' => Sales::count(),
                    'compras_count' => PurchaseModel::count(),
                ],
                'estructura' => [
                    'ventas_columns' => $ventasColumns,
                    'compras_columns' => $comprasColumns,
                ],
                'muestras' => [
                    'ventas_sample' => $ventasTest,
                    'compras_sample' => $comprasTest,
                ],
                'recientes' => [
                    'ventas_recientes' => $ventasRecientes,
                    'compras_recientes' => $comprasRecientes,
                ],
                'configuracion' => [
                    'base_datos' => config('database.default'),
                    'conexion' => config('database.connections.' . config('database.default')),
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Dashboard - Error en testModels: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}