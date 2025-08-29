<?php

namespace App\Http\Controllers;

use App\Models\ListPrice;
use App\Models\CurrenciesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ListPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $currencies = CurrenciesModel::all()->pluck('currency_name', 'id');
        return view('admin.list_price.list', compact('currencies'));
    }

    public function getListPrices()
    {
        \Log::info('Iniciando getListPrices');
        try {
            $listPrices = ListPrice::with(['currency', 'createdBy'])
                ->where('is_delete', 0)
                ->orderBy('id', 'desc')
                ->get();
            
            \Log::info('Datos obtenidos:', ['count' => $listPrices->count(), 'data' => $listPrices->toArray()]);
            
            return response()->json($listPrices);
        } catch (\Exception $e) {
            \Log::error('Error en getListPrices: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:value,percentage',
            'currency_id' => 'required|exists:currencies,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'default' => 'boolean',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $listPrice = new ListPrice();
        $listPrice->name = $request->name;
        $listPrice->description = $request->description;
        $listPrice->type = $request->type;
        $listPrice->currency_id = $request->currency_id;
        $listPrice->start_date = $request->start_date;
        $listPrice->end_date = $request->end_date;
        $listPrice->default = $request->default ?? false;
        $listPrice->status = $request->status ?? true;
        $listPrice->created_by = Auth::id();
        $listPrice->company_id = Auth::user()->company_id;
        $listPrice->save();

        return response()->json([
            'success' => true,
            'message' => 'Lista de precios creada exitosamente'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ListPrice $listPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $listPrice = ListPrice::findOrFail($id);
        return response()->json($listPrice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:value,percentage',
            'currency_id' => 'required|exists:currencies,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'default' => 'boolean',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $listPrice = ListPrice::findOrFail($id);
        $listPrice->name = $request->name;
        $listPrice->description = $request->description;
        $listPrice->type = $request->type;
        $listPrice->currency_id = $request->currency_id;
        $listPrice->start_date = $request->start_date;
        $listPrice->end_date = $request->end_date;
        $listPrice->default = $request->default ?? false;
        $listPrice->status = $request->status ?? true;
        $listPrice->save();

        return response()->json([
            'success' => true,
            'message' => 'Lista de precios actualizada exitosamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $listPrice = ListPrice::findOrFail($id);
        $listPrice->is_delete = true;
        $listPrice->save();

        return response()->json([
            'success' => true,
            'message' => 'Lista de precios eliminada exitosamente'
        ]);
    }
}
