<?php

namespace App\Http\Controllers;

use App\Models\VoucherTypeModel;
use App\Models\DocumentTypeModel;
use App\Models\TypeDocumentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingDocumentController extends Controller
{
    //
    public function list()
    {
        return view('admin.account_document_type.list');
    }
    public function getDocumentTypes(Request $request) {
        $document_types = VoucherTypeModel::where('is_delete', 0)->get();
        return response()->json($document_types);
        
    }
    public function store(Request $request) {
        $request->validate([
            'name' =>'required|string|max:255',
        ]);

        $accountign_document = new VoucherTypeModel();
        $accountign_document->code = $request->code;
        $accountign_document->name = $request->name;
        $accountign_document->created_by = Auth::user()->id;
        $accountign_document->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }
    public function edit($id) {
        $document_type = VoucherTypeModel::find($id);
        return response()->json($document_type);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' =>'required|string|max:255',
        ]);
        $accountign_document = VoucherTypeModel::find($id);
        $accountign_document->code = $request->code;
        $accountign_document->name = $request->name;

       // $accountign_document->updated_by = Auth::user()->id;
        $accountign_document->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroy($id) {
        $accountign_document = VoucherTypeModel::find($id);
        $accountign_document->is_delete = 1;
        $accountign_document->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
