<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.status_order.list');
    }
public function getStatusOrders() {
    $order_status = OrderStatus::where('is_delete', 0)->get();
    return response()->json($order_status);
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
        $order_status = new OrderStatus();

        $order_status->description = $request->description; 
        $order_status->name = $request->name; 

        $order_status->save();
        // retornar json
        return response()->json(['success' => 'Registro Creado con Exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $order_status = OrderStatus::find($id);
        return response()->json($order_status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $order_status = OrderStatus::find($id);
        $order_status->name = $request->name;
        $order_status->description = $request->description;
        $order_status->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $order_status = OrderStatus::find($id);
        $order_status->is_delete = 1;
        $order_status->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
