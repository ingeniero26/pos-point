<?php

namespace App\Http\Controllers;

use App\Models\ItemsModel;
use App\Models\TmpPurchaseModel;
use Illuminate\Http\Request;

class PurchaseTempController extends Controller
{
    //
    
    public function tmp_purchase(Request $request) {
        //buscar item por barcode
        $item = ItemsModel::where('barcode', $request->barcode)->first();
        
        //validar si el item existe
        if($item){
            $session_id = session()->getId();


            $temp_purchase_exist = TmpPurchaseModel::where('item_id', $item->id)
            ->where('session_id', $session_id)->first();
            if($temp_purchase_exist){
                $temp_purchase_exist->quantity += $request->quantity;
                $temp_purchase_exist->save();
                return response()->json(['success' =>true,'message' => 'Item Encontrado']);
            } else {
            $tmp_item = new TmpPurchaseModel();
            $tmp_item->quantity = $request->quantity;
            $tmp_item->cost_price = $item->cost_price;
            $tmp_item->item_id = $item->id;
            // almacenar la session del usuario
            $tmp_item->session_id = $session_id;
          
            $tmp_item->save();
            return response()->json(['success' =>true, 'message' => 'Item Encontrado']);
        }
        }else{
            return response()->json(['error' => false, 'message' => 'Item no encontrado']);
        }
       
    }

    public function updateQuantity(Request $request) {
        $request->validate([
            'id' =>'required|integer',
            'quantity' =>'required|integer|min:1',
        ]);
        try {
            // Assuming you have a TmpPurchaseModel
            $tmpPurchase = TmpPurchaseModel::findOrFail($request->id);
            $tmpPurchase->quantity = $request->quantity;
            $tmpPurchase->save();
            return response()->json(['success' => true,'message' => 'Cantidad actualizada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => 'Error al actualizar la cantidad: '. $e->getMessage()], 500);
        }
    }
    public function updateCostPrice(Request $request) 
    {
        $request->validate([
            'id' =>'required|integer',
            'cost_price' =>'required|numeric|min:0',
        ]);
        try {
            // Assuming you have a TmpPurchaseModel
            $tmpPurchase = TmpPurchaseModel::findOrFail($request->id);
            $tmpPurchase->cost_price = $request->cost_price;
            $tmpPurchase->save();
            return response()->json(['success' => true,'message' => 'Precio de costo actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => 'Error al actualizar el precio de costo: '. $e->getMessage()], 500);
        }

    }
    public function updateDiscount(Request $request)
        {
            $request->validate([
                'id' => 'required|integer',
                'discount_percent' => 'required|numeric|min:0|max:100',
            ]);

            try {
                // Assuming you have a TmpPurchaseModel
                $tmpPurchase = TmpPurchaseModel::findOrFail($request->id);
                $tmpPurchase->discount_percent = $request->discount_percent;
                $tmpPurchase->save();

                return response()->json(['success' => true, 'message' => 'Descuento actualizado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error al actualizar el descuento: ' . $e->getMessage()], 500);
            }
        }
        // eliminar
        public function destroy($id) 
        {
            $tmp_purchase = TmpPurchaseModel::find($id);
            if($tmp_purchase) {
                $tmp_purchase->delete();
                return response()->json(['success' => true,'message' => 'Item eliminado correctamente']);
            } else {
                return response()->json(['success' => false,'message' => 'Item no encontrado']);
            }
        }
}
