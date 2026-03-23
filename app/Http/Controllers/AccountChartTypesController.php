<?php

namespace App\Http\Controllers;

use App\Models\AccountChartTypes;
use Illuminate\Http\Request;

class AccountChartTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return view('admin.account_chart_types.list');
    }
    public function index()
    {
        //
        $accountChartTypes = AccountChartTypes::all();
        return response()->json($accountChartTypes);
    }

    public function fetch(Request $request)
    {
        $query = AccountChartTypes::query()->with('parentType');

        // Búsqueda global
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where('type_code', 'like', "%{$search}%")
                  ->orWhere('type_name', 'like', "%{$search}%")
                  ->orWhere('type_description', 'like', "%{$search}%");
        }

        // Total de registros sin filtro
        $totalRecords = AccountChartTypes::count();
        
        // Total de registros filtrados
        $filteredRecords = $query->count();

        // Paginación
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        
        $data = $query->offset($start)
                      ->limit($length)
                      ->get()
                      ->map(function($item) {
                          $parentName = '-';
                          if ($item->parentType) {
                              $parentName = $item->parentType->type_code . ' - ' . $item->parentType->type_name;
                          }

                          return [
                              'id' => $item->id,
                              'type_code' => $item->type_code ?? '-',
                              'type_name' => $item->type_name ?? '-',
                              'type_description' => $item->type_description ?? '-',
                                
                              'normal_balance' => match($item->normal_balance) {
                                  'D' => 'Débito',
                                  'C' => 'Crédito',
                                  default => $item->normal_balance ?? '-'
                              },

                              'parent_account_type' => $parentName,
                              'balance_sheet_section' => $item->balance_sheet_section ?? '-',
                              'income_statement_section' => $item->income_statement_section ?? '-',
                              'appears_in_report' => $item->statement_type ?? 'both',
                              'level' => $item->level ?? '-',
                              'allows_movement' => $item->is_movement ? 'Sí' : 'No',
                              'requires_detail' => $item->requires_detail ? 'Sí' : 'No',
                              'sort_order' => $item->sort_order ?? '-',
                              'status' => $item->status ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>',
                              'created_at' => $item->created_at?->format('Y-m-d H:i') ?? '-',
                              'updated_at' => $item->updated_at?->format('Y-m-d H:i') ?? '-',
                              'actions' => '<a href="#" class="btn btn-sm btn-primary">Editar</a> <a href="#" class="btn btn-sm btn-danger">Eliminar</a>'
                          ];
                      });

        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    /**
     * Obtener tipos padres disponibles
     */
    public function getParentTypes()
    {
        $types = AccountChartTypes::where('status', 1)
                                  ->select('id', 'type_name', 'type_code')
                                  ->orderBy('type_code')
                                  ->get();
        
        return response()->json($types);
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
        try {
            $validated = $request->validate([
                'type_code' => 'required|string|max:20|unique:account_chart_types,type_code',
                'type_name' => 'required|string|max:100',
                'type_description' => 'nullable|string',
                'normal_balance' => 'required|in:D,C',
                'level' => 'required|integer|in:1,2,3',
                'balance_sheet_section' => 'nullable|string|max:50',
                'income_statement_section' => 'nullable|string|max:50',
                'statement_type' => 'nullable|in:balance_sheet,income_statement,both,none',
                'is_movement' => 'nullable|boolean',
                'requires_detail' => 'nullable|boolean',
                'sort_order' => 'nullable|integer',
                'parent_type_id' => 'nullable|integer|exists:account_chart_types,id',
                'status' => 'nullable|boolean'
            ]);

            // Convertir checkboxes
            $validated['is_movement'] = $request->has('is_movement') ? 1 : 0;
            $validated['requires_detail'] = $request->has('requires_detail') ? 1 : 0;
            $validated['status'] = $request->has('status') ? 1 : 0;
            $validated['created_by'] = auth()->id();
            $validated['statement_type'] = $validated['statement_type'] ?? 'both';

            $accountChartType = AccountChartTypes::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Tipo de cuenta contable creado exitosamente',
                'data' => $accountChartType
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el tipo de cuenta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountChartTypes $accountChartTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountChartTypes $accountChartTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountChartTypes $accountChartTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountChartTypes $accountChartTypes)
    {
        //
    }
}
