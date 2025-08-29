<?php

namespace App\Http\Controllers;

use App\Models\TaxesModel;
use App\Models\TypeTax;
use Illuminate\Http\Request;

class TaxesController extends Controller
{
    //
    
    public function taxList(Request $request) 
    {
        $taxesType = TypeTax::all();
        return view('admin.taxes.list', compact('taxesType'));
    }
    
    public function getTaxes()
    {
        $taxes = TaxesModel::with('taxesType')->get();
        return response()->json($taxes);
    }
    public function storeTax(Request $request)
    {
        $request->validate([
            'tax_name' =>'required|string|max:255',
        ]);

        $taxes = new TaxesModel();
        $taxes->tax_type_id = $request->tax_type_id;
        $taxes->tax_type = $request->tax_type;
        $taxes->rate = $request->rate;
        $taxes->tax_name = $request->tax_name;
        $taxes->description = $request->description;
        $taxes->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }

    public function editTax($id)
    {
        $taxes = TaxesModel::find($id);
        return response()->json($taxes);
    }

    public function updateTax(Request $request, $id)
    {
        $request->validate([
            'tax_name' =>'required|string|max:255',
        ]);
        $taxes = TaxesModel::find($id);
        $taxes->tax_type_id = $request->tax_type_id;
        $taxes->tax_type = $request->tax_type;
        $taxes->rate = $request->rate;
        $taxes->tax_name = $request->tax_name;
        $taxes->description = $request->description;
        $taxes->save();

        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroyTax($id)
    {
        $taxes = TaxesModel::findOrFail($id);
        $taxes->delete();

        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
    public function getTaxRate($id)
        {
            $tax = TaxesModel::find($id);
            if ($tax) {
                return response()->json(['rate' => $tax->rate], 200);
            } else {
                return response()->json(['error' => 'Tarifa no encontrada'], 404);
            }
        }

}
