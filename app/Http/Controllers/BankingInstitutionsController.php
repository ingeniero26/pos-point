<?php

namespace App\Http\Controllers;

use App\Models\BankingInstitutionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankingInstitutionsController extends Controller
{
    //
    public function list(Request $request)
    {
        return view('admin.bank_entitys.list');
    }
    public  function getBanks() 
    {
        $banks = BankingInstitutionsModel::where('is_delete',0)->get();
        return response()->json($banks);
    }
    public function store(Request $request) {
        $request->validate([
            'name' =>'required|string|max:255',
        ]);

        $category = new BankingInstitutionsModel();
        $category->code = $request->code;
        $category->name = $request->name;
        $category->created_by = Auth::user()->id;
        $category->company_id = Auth::user()->company_id;
        $category->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }
    public function edit($id) {
        $bank = BankingInstitutionsModel::find($id);
        return response()->json($bank);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' =>'required|string|max:255',
        ]);
        $bank = BankingInstitutionsModel::find($id);
        $bank->code = $request->code;
        $bank->name = $request->name;
        $bank->updated_by = Auth::user()->id;
        $bank->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroy($id) {
        $bank = BankingInstitutionsModel::find($id);
        $bank->is_delete = 1;
        $bank->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
