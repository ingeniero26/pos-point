<?php

namespace App\Http\Controllers;

use App\Models\CompensationFund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompensationFundController extends Controller
{
    public function list()
    {
        return view('admin.compensation_funds.list');
    }

    public function getCompensationFunds()
    {
        $compensationFunds = CompensationFund::where('is_delete', 0)
            ->orderBy('id')
            ->get(['id', 'name', 'code', 'status', 'created_at', 'updated_at']);

        return response()->json($compensationFunds);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'status' => ['sometimes', 'boolean'],
        ]);

        $compensationFund = new CompensationFund();
        $compensationFund->name = $validated['name'];
        $compensationFund->code = $validated['code'];
        $compensationFund->created_by = Auth::user()->id;
        $compensationFund->company_id = Auth::user()->company_id;
        $compensationFund->status = $validated['status'] ?? 1;
        $compensationFund->is_delete = 0;
        $compensationFund->save();

        return response()->json([
            'success' => 'Caja de compensación creada correctamente.',
            'compensationFund' => $compensationFund,
        ], 201);
    }

    public function show($id)
    {
        //
        $compensationFund = CompensationFund::find($id);
        return response()->json($compensationFund);
    }

    public function edit($id)
    {
        $compensationFund = CompensationFund::where('is_delete', 0)->findOrFail($id);

        return response()->json($compensationFund);
    }
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'status' => ['sometimes', 'boolean'],
        ]);

        $compensationFund = CompensationFund::where('is_delete', 0)->findOrFail($id);
        $compensationFund->name = $validated['name'];
        $compensationFund->code = $validated['code'];
        if (array_key_exists('status', $validated)) {
            $compensationFund->status = $validated['status'];
        }
        $compensationFund->save();

        return response()->json([
            'success' => 'Caja de compensación actualizada correctamente.',
            'compensationFund' => $compensationFund,
        ]);
    }
   
    public function destroy($id)
    {
        $compensationFund = CompensationFund::where('is_delete', 0)->findOrFail($id);
        $compensationFund->is_delete = 1;
        $compensationFund->save();

        return response()->json(['success' => 'Caja de compensación eliminada correctamente.']);
    }

    public function toggleStatus($id)
    {
        $compensationFund = CompensationFund::where('is_delete', 0)->findOrFail($id);
        $compensationFund->status = !(bool) $compensationFund->status;
        $compensationFund->save();

        return response()->json([
            'success' => 'Estado de la caja de compensación actualizado correctamente.',
            'status' => (bool) $compensationFund->status,
        ]);
    }
}
