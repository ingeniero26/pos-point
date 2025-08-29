<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller {
public function index()
{
    // Ventas del mes actual
    $totalSales = \App\Models\Sales::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total_amount');
    
    // Compras del mes actual
    $totalPurchases = \App\Models\PurchaseModel::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total_amount');
    
    // Productos con bajo stock
    $lowStockCount = \App\Models\ItemsModel::where('stock', '<=', 'min_stock')
        ->where('status', 'active')
        ->count();
    
    // Cuentas por cobrar
    $accountsReceivable = \App\Models\Sales::where('payment_status', 'pending')
        ->sum('pending_amount');
    
    // Cuentas por pagar
    $accountsPayable = \App\Models\AccountsPayableModel::where('account_statuses_id', '1')
        ->where('company_id', auth()->user()->company_id)
        ->where('is_delete', 0)
        ->whereRaw('balance > 0')
        ->sum('balance') ?? 0;
    
    // Total de productos
    $totalProducts = \App\Models\ItemsModel::where('status', 'active')->count();
    
    // Total de clientes
    $totalCustomers = \App\Models\PersonModel::count();
    
    // Total de proveedores
    $totalSuppliers = \App\Models\PersonModel::count();
    
    return view('admin_dashboard.list', compact(
        'totalSales',
        'totalPurchases',
        'lowStockCount',
        'accountsReceivable',
        'accountsPayable',
        'totalProducts',
        'totalCustomers',
        'totalSuppliers'
    ));
}
}