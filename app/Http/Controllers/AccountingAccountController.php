<?php

namespace App\Http\Controllers;

use App\Models\AccountingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccountingAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $accountTypes = ['ASSETS', 'LIABILITIES', 'EQUITY', 'INCOME', 'EXPENSES', 'COSTS'];

        $parentAccounts = AccountingAccount::where('company_id', Auth::user()->company_id)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.accounting_account.list', compact('accountTypes', 'parentAccounts'));
    }

    /**
     * Get all accounting accounts for DataTables
     */
    public function getAccounts(Request $request)
    {
        $query = AccountingAccount::with(['parent'])
            ->where('company_id', Auth::user()->company_id);

        // Apply filters
        if ($request->has('account_type') && $request->account_type) {
            $query->where('account_type', $request->account_type);
        }

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('account_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $accounts = $query->orderBy('id', 'asc')
            ->get();
            
        return response()->json($accounts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accountTypes = ['ASSETS', 'LIABILITIES', 'EQUITY', 'INCOME', 'EXPENSES', 'COSTS'];
        $natureTypes = ['DEBIT', 'CREDIT'];
            
        $parentAccounts = AccountingAccount::where('company_id', Auth::user()->company_id)
            ->orderBy('id', 'asc')
            ->get();
            
        return view('admin.accounting_account.add', compact('accountTypes', 'parentAccounts', 'natureTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_code' => 'required|string|max:255|unique:accounting_accounts,account_id',
            'account_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'level' => 'required|integer|min:1|max:127',
            'parent_account' => 'nullable|string|max:10|exists:accounting_accounts,account_id',
            'account_type' => 'required|in:ASSET,LIABILITY,EQUITY,INCOME,EXPENSES,COSTS',
            'nature' => 'required|in:DEBIT,CREDIT',
            'allow_movement' => 'boolean',
            'requires_third_party' => 'boolean',
            'requires_cost_center' => 'boolean',
            'comments' => 'nullable|string|max:255',
        ], [
            'account_code.required' => 'El código de cuenta es requerido',
            'account_code.unique' => 'El código de cuenta ya existe',
            'account_code.max' => 'El código no puede tener más de 255 caracteres',
            'account_name.required' => 'El nombre de la cuenta es requerido',
            'account_name.max' => 'El nombre no puede tener más de 255 caracteres',
            'description.max' => 'La descripción no puede tener más de 255 caracteres',
            'level.required' => 'El nivel es requerido',
            'level.integer' => 'El nivel debe ser un número',
            'level.min' => 'El nivel mínimo es 1',
            'level.max' => 'El nivel máximo es 127',
            'parent_account.exists' => 'La cuenta padre no existe',
            'account_type.required' => 'Debe seleccionar un tipo de cuenta',
            'nature.required' => 'Debe seleccionar una naturaleza',
            'comments.max' => 'Los comentarios no pueden tener más de 255 caracteres'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            $account = new AccountingAccount();
            $account->account_code = $request->account_code;
            $account->account_name = $request->account_name;
            $account->description = $request->description;
            $account->level = $request->level;
            $account->parent_account = $request->parent_account;
            $account->account_type = $request->account_type;
            $account->nature = $request->nature;
            $account->allow_movement = $request->has('allow_movement') ? $request->allow_movement : 1;
            $account->requires_third_party = $request->has('requires_third_party') ? $request->requires_third_party : 0;
            $account->requires_cost_center = $request->has('requires_cost_center') ? $request->requires_cost_center : 0;
            $account->comments = $request->comments;
            $account->created_by = Auth::id();
            $account->company_id = Auth::user()->company_id;
            $account->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cuenta contable creada exitosamente',
                'account' => $account
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la cuenta contable: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $account = AccountingAccount::with(['parent', 'company'])
            ->where('account_id', $id)
            ->firstOrFail();
            
        return response()->json($account);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $account = AccountingAccount::where('id', $id)->firstOrFail();
        // devolver json
        return response()->json($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $account = AccountingAccount::where('id', $id)->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:127',
            'parent_account' => 'nullable|string|max:10|exists:accounting_accounts,id',
            'account_type' => 'required|in:ASSETS,LIABILITIES,EQUITY,INCOME,EXPENSES,COSTS',
            'nature' => 'required|in:DEBIT,CREDIT',
            'allow_movement' => 'boolean',
            'requires_third_party' => 'boolean',
            'requires_cost_center' => 'boolean',
            'comments' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            $account->account_name = $request->account_name;
            $account->level = $request->level;
            $account->parent_account = $request->parent_account == $id ? null : $request->parent_account; // Prevent self-reference
            $account->account_type = $request->account_type;
            $account->nature = $request->nature;
            $account->allow_movement = $request->has('allow_movement') ? $request->allow_movement : $account->allow_movement;
            $account->requires_third_party = $request->has('requires_third_party') ? $request->requires_third_party : $account->requires_third_party;
            $account->requires_cost_center = $request->has('requires_cost_center') ? $request->requires_cost_center : $account->requires_cost_center;
            $account->comments = $request->comments;
            $account->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cuenta contable actualizada exitosamente',
                'account' => $account
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la cuenta contable: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $account = AccountingAccount::where('id', $id)->firstOrFail();
            $account->allow_movement = $request->status;
            $account->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado de la cuenta actualizado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $account = AccountingAccount::where('id', $id)->firstOrFail();
            
            // Check if account has child accounts
            $hasChildren = AccountingAccount::where('parent_account', $id)
                ->exists();
                
            if ($hasChildren) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la cuenta porque tiene cuentas hijas asociadas'
                ], 422);
            }
            
            // Check if account is used in journal entries
            $isUsed = DB::table('accounting_journal_entry_lines')
                ->where('id', $id)
                ->exists();
                
            if ($isUsed) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la cuenta porque está siendo utilizada en asientos contables'
                ], 422);
            }
            
            // Eliminar la cuenta
            $account->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Cuenta contable eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la cuenta: ' . $e->getMessage()
            ], 500);
        }
    }
}
