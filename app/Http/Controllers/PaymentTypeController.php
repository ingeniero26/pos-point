<?php

namespace App\Http\Controllers;

use App\Models\PaymentFormModel;
use App\Models\PaymentTypeModel;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    //
    public function list()
    {
        return view('admin.payment_type.list');
    }
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' =>'required|max:255',
            'code' =>'required|max:255'
        ]);

        // Create a new payment method
        $paymentMethod = new PaymentTypeModel();
        $paymentMethod->code = $request->code;
        $paymentMethod->name = $request->name;
       
        $paymentMethod->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }
    public function getPaymentMethods() {
       
        $payment_form = PaymentTypeModel::where('is_delete', 0)->get();
        return response()->json($payment_form);

    }
    public function edit($id) {
        $payment_form = PaymentTypeModel::find($id);
        return response()->json($payment_form);
    }
    public function update(Request $request, $id) {
        // Validate the request
        $request->validate([
            'name' =>'required|max:255',
            'code' =>'required|max:255'
        ]);

        // Update the payment method
        $paymentMethod = PaymentTypeModel::find($id);
        $paymentMethod->code = $request->code;
        $paymentMethod->name = $request->name;
        $paymentMethod->days = $request->days;
        $paymentMethod->save();

        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroy($id) {
        // Delete the payment method
        $paymentMethod = PaymentTypeModel::find($id);
        $paymentMethod->is_delete = 1;
        $paymentMethod->save();

        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }

    
}
