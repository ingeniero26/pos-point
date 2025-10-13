<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\OpportunityStage;
use App\Models\PersonModel;
use App\Models\ContactSource;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OpportunityController extends Controller
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
        
        $query = Opportunity::active()
            ->byCompany($companyId)
            ->with(['third', 'stage', 'source', 'responsibleUser', 'company', 'priority']);

        // Filtros
        if ($request->filled('stage_id')) {
            $query->where('stage_id', $request->stage_id);
        }

        if ($request->filled('responsible_user_id')) {
            $query->where('responsible_user_id', $request->responsible_user_id);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'open':
                    $query->open();
                    break;
                case 'won':
                    $query->won();
                    break;
                case 'lost':
                    $query->lost();
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%");
            });
        }

        $opportunities = $query->orderBy('created_at', 'desc')->paginate(15);

        // Datos para filtros
        $stages = OpportunityStage::active()->byCompany($companyId)->ordered()->get();
        $users = User::where('company_id', $companyId)->get();

        return view('opportunities.index', compact('opportunities', 'stages', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companyId = Auth::user()->company_id;
        
        $stages = OpportunityStage::active()->enabled()->byCompany($companyId)->ordered()->get();
        $contacts = PersonModel::where('company_id', $companyId)->where('is_delete', false)
        ->where('type_third_id','=', 1)->get();
        $sources = ContactSource::where('company_id', $companyId)->where('status', true)->get();
        $users = User::where('company_id', $companyId)->get();
        $companies = Companies::where('status', true)->get();

        return view('opportunities.create', compact('stages', 'contacts', 'sources', 'users', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'third_id' => 'nullable|exists:persons,id',
            'contact_name' => 'required|string|max:500',
            'contact_email' => 'nullable|email|max:500',
            'contact_phone' => 'nullable|string|max:500',
            'source_id' => 'nullable|exists:contact_sources,id',
            'stage_id' => 'required|exists:opportunity_stages,id',
            'estimated_value' => 'required|numeric|min:0',
            'probability' => 'required|numeric|min:0|max:100',
            'estimated_closing_date' => 'nullable|date|after:today',
            'responsible_user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_delete'] = false;

        $opportunity = Opportunity::create($validated);

        return redirect()->route('opportunities.index')
            ->with('success', 'Oportunidad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Opportunity $opportunity)
    {
        if ($opportunity->is_delete) {
            abort(404);
        }

        $opportunity->load(['third', 'stage', 'source', 'responsibleUser', 'company', 'priority', 'creator']);

        return view('opportunities.show', compact('opportunity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opportunity $opportunity)
    {
        if ($opportunity->is_delete) {
            abort(404);
        }

        $companyId = $opportunity->company_id;
        
        $stages = OpportunityStage::active()->enabled()->byCompany($companyId)->ordered()->get();
        $contacts = PersonModel::where('company_id', $companyId)->where('is_delete', false)->get();
        $sources = ContactSource::where('company_id', $companyId)->where('status', true)->get();
        $users = User::where('company_id', $companyId)->get();
        $companies = Companies::where('status', true)->get();

        return view('opportunities.edit', compact('opportunity', 'stages', 'contacts', 'sources', 'users', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opportunity $opportunity)
    {
        if ($opportunity->is_delete) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'third_id' => 'nullable|exists:person,id',
            'contact_name' => 'required|string|max:500',
            'contact_email' => 'nullable|email|max:500',
            'contact_phone' => 'nullable|string|max:500',
            'source_id' => 'nullable|exists:contact_sources,id',
            'stage_id' => 'required|exists:opportunity_stages,id',
            'estimated_value' => 'required|numeric|min:0',
            'probability' => 'required|numeric|min:0|max:100',
            'estimated_closing_date' => 'nullable|date',
            'responsible_user_id' => 'required|exists:users,id',
            'reason_lost' => 'nullable|string'
        ]);

        // Si cambió la etapa, usar el método moveToStage
        if ($opportunity->stage_id != $validated['stage_id']) {
            $opportunity->moveToStage($validated['stage_id'], $validated['reason_lost'] ?? null);
            unset($validated['stage_id'], $validated['reason_lost']);
        }

        $opportunity->update($validated);

        return redirect()->route('opportunities.index')
            ->with('success', 'Oportunidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opportunity $opportunity)
    {
        $opportunity->softDelete();

        return redirect()->route('opportunities.index')
            ->with('success', 'Oportunidad eliminada exitosamente.');
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $opportunity->restore();

        return redirect()->route('opportunities.index')
            ->with('success', 'Oportunidad restaurada exitosamente.');
    }

    /**
     * Move opportunity to different stage.
     */
    public function moveToStage(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'stage_id' => 'required|exists:opportunity_stages,id',
            'reason_lost' => 'nullable|string'
        ]);

        $opportunity->moveToStage($validated['stage_id'], $validated['reason_lost'] ?? null);

        return response()->json([
            'success' => true,
            'message' => 'Oportunidad movida exitosamente.',
            'opportunity' => $opportunity->load('stage')
        ]);
    }

    /**
     * Get opportunities for Kanban board.
     */
    public function kanban(Request $request)
    {
        $companyId = Auth::user()->company_id ?? $request->get('company_id');
        
        $stages = OpportunityStage::active()
            ->enabled()
            ->byCompany($companyId)
            ->ordered()
            ->with(['opportunities' => function($query) use ($companyId) {
                $query->active()
                      ->byCompany($companyId)
                      ->with(['third', 'responsibleUser'])
                      ->orderBy('created_at', 'desc');
            }])
            ->get();

        return view('opportunities.kanban', compact('stages'));
    }

    /**
     * Get opportunities statistics.
     */
    public function statistics(Request $request)
    {
        $companyId = Auth::user()->company_id ?? $request->get('company_id');
        
        $stats = [
            'total' => Opportunity::active()->byCompany($companyId)->count(),
            'open' => Opportunity::active()->byCompany($companyId)->open()->count(),
            'won' => Opportunity::active()->byCompany($companyId)->won()->count(),
            'lost' => Opportunity::active()->byCompany($companyId)->lost()->count(),
            'total_value' => Opportunity::active()->byCompany($companyId)->sum('estimated_value'),
            'won_value' => Opportunity::active()->byCompany($companyId)->won()->sum('estimated_value'),
            'pipeline_value' => Opportunity::active()->byCompany($companyId)->open()->sum('estimated_value'),
        ];

        // Estadísticas por etapa
        $stageStats = OpportunityStage::active()
            ->byCompany($companyId)
            ->withCount(['opportunities' => function($query) use ($companyId) {
                $query->active()->byCompany($companyId);
            }])
            ->with(['opportunities' => function($query) use ($companyId) {
                $query->active()->byCompany($companyId)->select('stage_id', DB::raw('SUM(estimated_value) as total_value'));
            }])
            ->get();

        return response()->json([
            'stats' => $stats,
            'stage_stats' => $stageStats
        ]);
    }

    /**
     * Get opportunities for API/AJAX requests.
     */
    public function getOpportunities(Request $request)
    {
        $companyId = $request->get('company_id', Auth::user()->company_id);
        
        $opportunities = Opportunity::active()
            ->byCompany($companyId)
            ->with(['stage', 'responsibleUser'])
            ->select('id', 'name', 'estimated_value', 'probability', 'stage_id', 'responsible_user_id')
            ->get();

        return response()->json($opportunities);
    }
}