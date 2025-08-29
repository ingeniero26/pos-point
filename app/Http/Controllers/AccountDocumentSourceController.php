<?php

namespace App\Http\Controllers;

use App\Models\AccountingSourceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountDocumentSourceController extends Controller
{
    //
    public function list()
    {
        return view('admin.account_document_source.list');
    }
    public function getFinancialSources(Request $request) {
        $sources = AccountingSourceModel::where('is_delete', 0)->get();
        return response()->json($sources);
    }
    public function store(Request $request) {
        $request->validate([
            'name' =>'required|string|max:255',
        ]);

        $category = new AccountingSourceModel();
        $category->code = $request->code;
        $category->name = $request->name;
        $category->created_by = Auth::user()->id;
        $category->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }
    public function edit($id){
        $source = AccountingSourceModel::find($id);
        return response()->json($source);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' =>'required|string|max:255',
        ]);
        $source = AccountingSourceModel::find($id);
        $source->name = $request->name;
        $source->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroy($id){
        $source = AccountingSourceModel::find($id);
        $source->is_delete = 1;
        $source->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }


}
