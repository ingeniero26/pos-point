<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodModel;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function list()
    {
        return view('admin.payment_method.list');
    }
    public function getPaymentMethods(Request $request)
    {
        // retornar un json
        $payment_method= PaymentMethodModel::where('is_delete', 0)->get();
        return response()->json($payment_method);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $payment_method = new PaymentMethodModel();

        $payment_method->code = $request->code;
        $payment_method->name = $request->name;
        $payment_method->days = $request->days;
        $payment_method->save();
        return response()->json(['success' => 'Registro Creado con Exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $payment_method = PaymentMethodModel::find($id);
        return response()->json($payment_method);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $payment_method = PaymentMethodModel::find($id);
        $payment_method->code = $request->code;
        $payment_method->name = $request->name;
        $payment_method->days = $request->days;
        $payment_method->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $payment_method = PaymentMethodModel::find($id);
        $payment_method->is_delete = 1;
        $payment_method->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
