<?php

namespace App\Http\Controllers;

use App\Models\AdjustmentReason;
use Illuminate\Http\Request;
use App\Models\AdjustmentType;
use Illuminate\Support\Facades\Auth;

class AdjustmentReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        $adjustment_types = AdjustmentType::all();
        return view('admin.adjustment_reason.list', compact('adjustment_types'));
    }
    public function getAdjustmentReasons() {
        // is_delete = 0
        $adjustment_reasons = AdjustmentReason::with('adjustment_types')->where('is_delete', 0)->get();
        return response()->json($adjustment_reasons);
    }
    public function index()
    {
        //
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
        $request->validate([
            'adjustment_type_id' => 'required',
            'reason_code' => 'required',
            'reason_name' => 'required',
            'description' => 'required',
        ]);
        $adjustment_reason = new AdjustmentReason();
        $adjustment_reason->adjustment_type_id = $request->adjustment_type_id;
        $adjustment_reason->reason_code = $request->reason_code;
        $adjustment_reason->reason_name = $request->reason_name;
        $adjustment_reason->description = $request->description;
        $adjustment_reason->company_id = $request->company_id;
        $adjustment_reason->created_by = Auth::user()->id;
       
        $adjustment_reason->save();
        return response()->json(['success' => 'Registro Creado con Exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $adjustment_reason = AdjustmentReason::find($id);
        return response()->json($adjustment_reason);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $adjustment_reason = AdjustmentReason::find($id);
        return response()->json($adjustment_reason);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'adjustment_type_id' => 'required',
            'reason_code' => 'required',
            'reason_name' => 'required',
            'description' => 'required',
        ]);
        $adjustment_reason = AdjustmentReason::find($id);
        $adjustment_reason->adjustment_type_id = $request->adjustment_type_id;
        $adjustment_reason->reason_code = $request->reason_code;
        $adjustment_reason->reason_name = $request->reason_name;
        $adjustment_reason->description = $request->description;
        $adjustment_reason->company_id = $request->company_id;
        $adjustment_reason->updated_by = Auth::user()->id;
       
        $adjustment_reason->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $adjustment_reason = AdjustmentReason::find($id);
        $adjustment_reason->is_delete = 1;
        $adjustment_reason->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }

    /**
     * Get all adjustment reasons for select options
     */
    public function getAllAdjustmentReasons()
    {
        try {
            $reasons = AdjustmentReason::where('is_delete', 0)
                ->select('id', 'reason_name', 'reason_code')
                ->orderBy('reason_name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $reasons
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las razones de ajuste: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
