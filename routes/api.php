<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_middleware'),
    'verified'
])->group(function () {
    Route::get('/products/search', [ProductSearchController::class, 'search']);
    Route::get('/products/frequent', [ProductSearchController::class, 'frequent']);
    Route::get('/dashboard/totales', [DashboardController::class, 'getTotales']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 