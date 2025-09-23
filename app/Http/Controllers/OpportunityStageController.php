<?php

namespace App\Http\Controllers;

use App\Models\OpportunityStage;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OpportunityStageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id ?? $request->get('company_id');
        
        $stages = OpportunityStage::active()
            ->byCompany($companyId)
            ->ordered()
            ->with(['company', 'creator'])
            ->paginate(15);

        return view('opportunity-stages.index', compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Companies::where('status', true)->get();
        return view('opportunity-stages.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'closing_percentage' => 'required|numeric|min:0|max:100',
            'colour' => 'nullable|string|max:7',
            'is_closing_stage' => 'boolean',
            'company_id' => 'required|exists:companies,id'
        ]);

        // Obtener el siguiente orden
        $nextOrder = OpportunityStage::byCompany($validated['company_id'])
            ->active()
            ->max('order') + 1;

        $validated['order'] = $nextOrder;
        $validated['created_by'] = Auth::id();
        $validated['is_closing_stage'] = $request->has('is_closing_stage');
        $validated['status'] = $request->has('status') ? true : false;

        OpportunityStage::create($validated);

        return redirect()->route('opportunity-stages.index')
            ->with('success', 'Etapa de oportunidad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OpportunityStage $opportunityStage)
    {
        if ($opportunityStage->is_delete) {
            abort(404);
        }

        return view('opportunity-stages.show', compact('opportunityStage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpportunityStage $opportunityStage)
    {
        if ($opportunityStage->is_delete) {
            abort(404);
        }

        $companies = Companies::where('status', true)->get();
        return view('opportunity-stages.edit', compact('opportunityStage', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OpportunityStage $opportunityStage)
    {
        if ($opportunityStage->is_delete) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'closing_percentage' => 'required|numeric|min:0|max:100',
            'colour' => 'nullable|string|max:7',
            'is_closing_stage' => 'boolean',
            'company_id' => 'required|exists:companies,id',
            'status' => 'boolean'
        ]);

        $validated['is_closing_stage'] = $request->has('is_closing_stage');
        $validated['status'] = $request->has('status') ? true : false;

        $opportunityStage->update($validated);

        return redirect()->route('opportunity-stages.index')
            ->with('success', 'Etapa de oportunidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpportunityStage $opportunityStage)
    {
        $opportunityStage->softDelete();

        return redirect()->route('opportunity-stages.index')
            ->with('success', 'Etapa de oportunidad eliminada exitosamente.');
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore($id)
    {
        $stage = OpportunityStage::findOrFail($id);
        $stage->restore();

        return redirect()->route('opportunity-stages.index')
            ->with('success', 'Etapa de oportunidad restaurada exitosamente.');
    }

    /**
     * Update the order of stages.
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'stages' => 'required|array',
            'stages.*.id' => 'required|exists:opportunity_stages,id',
            'stages.*.order' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['stages'] as $stageData) {
                OpportunityStage::where('id', $stageData['id'])
                    ->update(['order' => $stageData['order']]);
            }
        });

        return response()->json(['success' => true, 'message' => 'Orden actualizado exitosamente.']);
    }

    /**
     * Toggle status of a stage.
     */
    public function toggleStatus(OpportunityStage $opportunityStage)
    {
        $opportunityStage->update(['status' => !$opportunityStage->status]);

        $message = $opportunityStage->status ? 'Etapa activada' : 'Etapa desactivada';
        
        return redirect()->route('opportunity-stages.index')
            ->with('success', $message . ' exitosamente.');
    }

    /**
     * Get stages for API/AJAX requests.
     */
    public function getStages(Request $request)
    {
        $companyId = $request->get('company_id', Auth::user()->company_id);
        
        $stages = OpportunityStage::active()
            ->enabled()
            ->byCompany($companyId)
            ->ordered()
            ->select('id', 'name', 'closing_percentage', 'colour', 'is_closing_stage')
            ->get();

        return response()->json($stages);
    }
}