<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\Companies;
use App\Models\CostCenterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        try {
            // Cargar áreas incluyendo las "soft deleted" ya que el campo is_delete maneja la eliminación
            $areas = Area:: // Incluir registros soft deleted
                with(['parent', 'manager', 'company', 'costCenter', 'creatorUser'])
                ->where('company_id', Auth::user()->company_id)
                ->where('is_delete', 0) // Usar nuestro campo personalizado is_delete
                ->orderBy('name')
                ->get();
                
            \Log::info('Areas loaded for company ' . Auth::user()->company_id . ':', ['count' => $areas->count()]);
            
            $data['areas'] = $areas;
            return view('admin.areas.list', $data);
            
        } catch (\Exception $e) {
            \Log::error('Error loading areas: ' . $e->getMessage());
            
            // Fallback: cargar todas las áreas para debug
            $areas = Area::
                with(['parent', 'manager', 'company', 'costCenter', 'creatorUser'])
                ->orderBy('name')
                ->get();
                
            $data['areas'] = $areas;
            return view('admin.areas.list', $data);
        }
    }

    /**
     * Get areas data for DataTables
     */
    public function getAreas(Request $request)
    {
        $areas = Area::
            with(['parent', 'manager', 'company', 'costCenter', 'creatorUser'])
            ->where('company_id', Auth::user()->company_id)
            ->where('is_delete', 0)
            ->orderBy('name')
            ->get();

        return response()->json($areas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $parentAreas = Area::
                where('company_id', Auth::user()->company_id)
                ->where('is_delete', 0)
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name']);
                
            $managers = User::where('company_id', Auth::user()->company_id)
                ->where('is_delete', 0)
                ->orderBy('name')
                ->get(['id', 'name']);
                
            $costCenters = CostCenterModel::where('company_id', Auth::user()->company_id)
                ->where('is_delete', 0)
                ->orderBy('name')
                ->get(['id', 'name']);
                
            return response()->json([
                'success' => true,
                'parentAreas' => $parentAreas,
                'managers' => $managers,
                'costCenters' => $costCenters
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:areas,name,NULL,id,company_id,' . Auth::user()->company_id . ',is_delete,0',
                'description' => 'nullable|string|max:1000',
                'parent_id' => 'nullable|exists:areas,id',
                'manager_id' => 'nullable|exists:users,id',
                'cost_center_id' => 'nullable|exists:cost_centers,id',
                'status' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $area = new Area();
            $area->name = $request->name;
            $area->description = $request->description;
            $area->parent_id = $request->parent_id;
            $area->manager_id = $request->manager_id;
            $area->cost_center_id = $request->cost_center_id;
            $area->company_id = Auth::user()->company_id;
            $area->created_by = Auth::user()->id;
            $area->status = $request->status;
            $area->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Área creada exitosamente',
                'area' => $area->load(['parent', 'manager', 'costCenter'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el área: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $area = Area::
            with(['parent', 'children', 'manager', 'company', 'costCenter', 'creatorUser'])
            ->where('company_id', Auth::user()->company_id)
            ->findOrFail($id);
            
        return view('admin.areas.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $area = Area::
                where('company_id', Auth::user()->company_id)
                ->findOrFail($id);
                
            $parentAreas = Area::
                where('company_id', Auth::user()->company_id)
                ->where('id', '!=', $id) // Excluir el área actual para evitar referencias circulares
                ->where('is_delete', 0)
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name']);
                
            $managers = User::where('company_id', Auth::user()->company_id)
                ->where('is_delete', 0)
                ->orderBy('name')
                ->get(['id', 'name']);
                
            $costCenters = CostCenterModel::where('company_id', Auth::user()->company_id)
                ->where('is_delete', 0)
                ->orderBy('name')
                ->get(['id', 'name']);
                
            return response()->json([
                'success' => true,
                'area' => $area,
                'parentAreas' => $parentAreas,
                'managers' => $managers,
                'costCenters' => $costCenters
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos del área: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $area = Area::
                where('company_id', Auth::user()->company_id)
                ->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:areas,name,' . $id . ',id,company_id,' . Auth::user()->company_id . ',is_delete,0',
                'description' => 'nullable|string|max:1000',
                'parent_id' => 'nullable|exists:areas,id|not_in:' . $id, // No puede ser padre de sí mismo
                'manager_id' => 'nullable|exists:users,id',
                'cost_center_id' => 'nullable|exists:cost_centers,id',
                'status' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $area->name = $request->name;
            $area->description = $request->description;
            $area->parent_id = $request->parent_id;
            $area->manager_id = $request->manager_id;
            $area->cost_center_id = $request->cost_center_id;
            $area->status = $request->status;
            $area->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Área actualizada exitosamente',
                'area' => $area->load(['parent', 'manager', 'costCenter'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el área: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $area = Area::
                where('company_id', Auth::user()->company_id)
                ->findOrFail($id);

            // Verificar si tiene áreas hijas
            $childrenCount = Area::
                where('parent_id', $id)
                ->where('is_delete', 0)
                ->count();
                
            if ($childrenCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el área porque tiene sub-áreas asociadas'
                ], 400);
            }

            DB::beginTransaction();
            
            // Usar nuestro campo personalizado is_delete en lugar de soft delete de Laravel
            $area->is_delete = 1;
            $area->save();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Área eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el área: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get areas hierarchy for select dropdown
     */
    public function getAreasHierarchy()
    {
        $areas = Area::
            where('company_id', Auth::user()->company_id)
            ->where('is_delete', 0)
            ->where('status', 1)
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return response()->json($this->buildHierarchy($areas));
    }

    /**
     * Debug method to check database data
     */
    public function debugAreas()
    {
        try {
            // Verificar conexión a la base de datos
            $connection = \DB::connection();
            $databaseName = $connection->getDatabaseName();
            
            // Verificar si la tabla existe
            $tableExists = \Schema::hasTable('areas');
            
            // Listar todas las tablas para verificar
            $allTables = \DB::select('SHOW TABLES');
            $tableNames = array_map(function($table) use ($databaseName) {
                $key = "Tables_in_" . $databaseName;
                return $table->$key;
            }, $allTables);
            
            // Intentar consulta directa a la tabla
            $directQuery = 0;
            if ($tableExists) {
                $directQuery = \DB::table('areas')->count();
            }
            
            // Consulta usando el modelo
            $allAreas = collect();
            $modelQueryCount = 0;
            try {
                $allAreas = Area::all();
                $modelQueryCount = $allAreas->count();
            } catch (\Exception $e) {
                $modelQueryCount = "Error: " . $e->getMessage();
            }
            
            $userCompanyId = Auth::user()->company_id;
            
            // Consulta con diferentes filtros para debug
            $areasWithCompany = collect();
            $areasNotDeleted = collect();
            $areasActive = collect();
            
            if ($tableExists && $modelQueryCount > 0) {
                $areasWithCompany = Area::where('company_id', $userCompanyId)->get();
                $areasNotDeleted = Area::where('is_delete', 0)->get();
                $areasActive = Area::where('status', 1)->get();
            }
            
            $debug = [
                'database_name' => $databaseName,
                'all_tables' => $tableNames,
                'table_exists' => $tableExists,
                'direct_query_count' => $directQuery,
                'model_query_count' => $modelQueryCount,
                'user_company_id' => $userCompanyId,
                'total_areas' => is_numeric($modelQueryCount) ? $modelQueryCount : 0,
                'areas_with_company' => $areasWithCompany->count(),
                'areas_not_deleted' => $areasNotDeleted->count(),
                'areas_active' => $areasActive->count(),
                'areas_data' => $allAreas->map(function($area) {
                    return [
                        'id' => $area->id,
                        'name' => $area->name,
                        'company_id' => $area->company_id,
                        'is_delete' => $area->is_delete,
                        'status' => $area->status,
                        'created_at' => $area->created_at
                    ];
                }),
                'raw_table_data' => $tableExists ? \DB::table('areas')->limit(5)->get() : []
            ];
            
            return response()->json($debug);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Build hierarchy array for select options
     */
    private function buildHierarchy($areas, $prefix = '')
    {
        $result = [];
        foreach ($areas as $area) {
            $result[] = [
                'id' => $area->id,
                'name' => $prefix . $area->name,
                'full_name' => $prefix . $area->name
            ];
            
            if ($area->children->count() > 0) {
                $result = array_merge($result, $this->buildHierarchy($area->children, $prefix . '-- '));
            }
        }
        return $result;
    }
}
