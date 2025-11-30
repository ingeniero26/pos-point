<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashRegisterController extends Controller
{
    //
    public function list(Request $request)
    {
        return view('admin.cash_register.list');
    }
    public function getCashRegisters(Request $request)
    {
        $cash_registers = CashRegister::with('branch')->get();
        return response()->json($cash_registers);
    }
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'location_description' => 'required',
            'branch_id' => 'required',
            'status' => 'required',
        ]);
        
        // Crear la nueva caja registradora
        $cashRegister = new CashRegister();
        $cashRegister->code = $request->code;
        $cashRegister->name = $request->name;
        $cashRegister->location_description = $request->location_description;
        $cashRegister->maximun_balance = $request->maximun_balance;
        $cashRegister->branch_id = $request->branch_id;
        $cashRegister->status = $request->status;
        $cashRegister->created_by = Auth::user()->id;
        $cashRegister->company_id = Auth::user()->company_id;
        $cashRegister->save();
        
        return response()->json(['success' => 'Caja registradora creada con éxito']);
    }
    public function edit($id)
    {
        $cashRegister = CashRegister::find($id);
        return response()->json($cashRegister);
    }
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'location_description' => 'required',
            'branch_id' => 'required',
            'status' => 'required',
        ]);
        // Actualizar la caja registradora existente
        $cashRegister = CashRegister::find($id);
        $cashRegister->code = $request->code;
        $cashRegister->name = $request->name;
        $cashRegister->location_description = $request->location_description;
        $cashRegister->maximun_balance = $request->maximun_balance;
        $cashRegister->branch_id = $request->branch_id;
        $cashRegister->status = $request->status;
        $cashRegister->updated_by = Auth::user()->id;
        $cashRegister->save();
        return response()->json(['success' => 'Caja registradora actualizada con éxito']);
    }
    public function destroy($id)
    {
        $cashRegister = CashRegister::find($id);
        // validar si la caja tiene movimientos asociados antes de eliminar
        if ($cashRegister->movements()->count() > 0) {
            return response()->json(['error' => 'No se puede eliminar la caja registradora porque tiene movimientos asociados'], 400);
        }
        // Eliminar la caja registradora
        if ($cashRegister) {
            $cashRegister->delete();
            return response()->json(['success' => 'Caja registradora eliminada con éxito']);
        } else {
            return response()->json(['error' => 'Caja registradora no encontrada'], 404);
        }
    }
    public function toggleStatus($id)
    {
        $cashRegister = CashRegister::find($id);
        if ($cashRegister) {
            $cashRegister->status = !$cashRegister->status;
            $cashRegister->save();
            return response()->json(['success' => 'Estado de la caja registradora actualizado con éxito']);
        } else {
            return response()->json(['error' => 'Caja registradora no encontrada'], 404);
        }
    }
}
