<?php

namespace App\Http\Controllers;

use App\Models\CostCenterModel;
use App\Models\ItemMovementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ItemMovementController extends Controller
{
    // mostrar todos los movimientos del item
    public function list()
    {
        return view('admin.kardex.list');
    }

    public function getMovements() {
        $movement = ItemMovementModel::where('is_delete', 0)
            ->with([
                'item',
                'warehouse',
                'movementType',
                'user',
                'company'
            ])
            ->orderBy('id', 'desc')
            ->get();
        
        // Debug information to help troubleshoot
        if ($movement->isEmpty()) {
            // Check if there are any records at all
            $totalRecords = ItemMovementModel::count();
            $deletedRecords = ItemMovementModel::where('is_delete', 1)->count();
            
            return response()->json([
                'status' => 'empty',
                'message' => 'No movement records found with is_delete=0',
                'debug' => [
                    'total_records' => $totalRecords,
                    'deleted_records' => $deletedRecords
                ]
            ]);
        }
        
        return response()->json($movement);
    }
    public function getMovementDetail(){

    }


}