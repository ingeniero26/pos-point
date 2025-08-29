<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\PucAccount;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PucAccountController extends Controller
{
    public function index(Request $request)
    {
        $query = PucAccount::with(['parent', 'company'])
            ->when(Auth::user()->is_role != 3, function ($q) {
                return $q->forCompany(Auth::user()->company_id);
            });

        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('account_code', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('account_type')) {
            $query->where('account_type', $request->account_type);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $accounts = $query->orderBy('account_code')->paginate(15);

        return view('admin.puc_account.list', compact('accounts'));
    }

    public function create()
    {
        $parentAccounts = PucAccount::active()
            ->when(Auth::user()->is_role != 3, function ($q) {
                return $q->forCompany(Auth::user()->company_id);
            })
            ->where('level', '<', 4)
            ->orderBy('account_code')
            ->get();

        $companies = Auth::user()->is_role == 3 ? Companies::all() : collect();

        return view('admin.puc_account.create', compact('parentAccounts', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_code' => 'required|string|max:10|unique:puc_accounts,account_code',
            'account_name' => 'required|string|max:255',
            'level' => 'required|integer|between:1,4',
            'parent_code' => 'nullable|string|exists:puc_accounts,account_code',
            'account_type' => 'required|in:ASSETS,LIABILITIES,EQUITY,INCOME,EXPENSES,COST',
            'nature' => 'required|in:DEBIT,CREDIT',
            'third_party_handling' => 'boolean',
            'cost_center_handling' => 'boolean',
            'accept_movement' => 'boolean',
            'company_id' => Auth::user()->is_role == 3 ? 'nullable|exists:companies,id' : 'nullable',
        ]);

        // Validate parent relationship
        if ($request->parent_code && $request->level > 1) {
            $parent = PucAccount::where('account_code', $request->parent_code)->first();
            if (!$parent || $parent->level >= $request->level) {
                return back()->withErrors(['parent_code' => 'El código padre debe ser de un nivel superior.']);
            }
        }

        $data = $request->all();
        $data['created_by'] = Auth::id();
        
        if (Auth::user()->is_role != 3) {
            $data['company_id'] = Auth::user()->company_id;
        }

        PucAccount::create($data);

        return redirect()->route('puc-accounts.index')
            ->with('success', 'Cuenta PUC creada exitosamente.');
    }

    public function show(PucAccount $pucAccount)
    {
        $this->authorizeAccess($pucAccount);
        
        $pucAccount->load(['parent', 'children', 'company', 'creator']);
        
        return view('admin.puc_account.show', compact('pucAccount'));
    }

    public function edit(PucAccount $pucAccount)
    {
        $this->authorizeAccess($pucAccount);

        $parentAccounts = PucAccount::active()
            ->when(Auth::user()->is_role != 3, function ($q) {
                return $q->forCompany(Auth::user()->company_id);
            })
            ->where('level', '<', 4)
            ->where('account_code', '!=', $pucAccount->account_code)
            ->orderBy('account_code')
            ->get();

        $companies = Auth::user()->is_role == 3 ? Companies::all() : collect();

        return view('admin.puc_account.edit', compact('pucAccount', 'parentAccounts', 'companies'));
    }

    public function update(Request $request, PucAccount $pucAccount)
    {
        $this->authorizeAccess($pucAccount);

        $request->validate([
            'account_code' => 'required|string|max:10|unique:puc_accounts,account_code,' . $pucAccount->id,
            'account_name' => 'required|string|max:255',
            'level' => 'required|integer|between:1,4',
            'parent_code' => 'nullable|string|exists:puc_accounts,account_code',
            'account_type' => 'required|in:ASSETS,LIABILITIES,EQUITY,INCOME,EXPENSES,COST',
            'nature' => 'required|in:DEBIT,CREDIT',
            'third_party_handling' => 'boolean',
            'cost_center_handling' => 'boolean',
            'accept_movement' => 'boolean',
            'company_id' => Auth::user()->is_role == 3 ? 'nullable|exists:companies,id' : 'nullable',
        ]);

        // Validate parent relationship
        if ($request->parent_code && $request->level > 1) {
            $parent = PucAccount::where('account_code', $request->parent_code)->first();
            if (!$parent || $parent->level >= $request->level) {
                return back()->withErrors(['parent_code' => 'El código padre debe ser de un nivel superior.']);
            }
        }

        $data = $request->all();
        
        if (Auth::user()->is_role != 3) {
            $data['company_id'] = Auth::user()->company_id;
        }

        $pucAccount->update($data);

        return redirect()->route('puc-accounts.index')
            ->with('success', 'Cuenta PUC actualizada exitosamente.');
    }

    public function destroy(PucAccount $pucAccount)
    {
        $this->authorizeAccess($pucAccount);

        // Check if account has children
        if ($pucAccount->children()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar una cuenta que tiene subcuentas.']);
        }

        $pucAccount->delete();

        return redirect()->route('puc-accounts.index')
            ->with('success', 'Cuenta PUC eliminada exitosamente.');
    }

    public function toggleStatus(PucAccount $pucAccount)
    {
        $this->authorizeAccess($pucAccount);

        $pucAccount->update(['status' => !$pucAccount->status]);

        $status = $pucAccount->status ? 'activada' : 'desactivada';
        
        return back()->with('success', "Cuenta {$status} exitosamente.");
    }

    public function getAccountsByParent(Request $request)
    {
        $parentCode = $request->parent_code;
        $level = $request->level;

        $accounts = PucAccount::active()
            ->when(Auth::user()->is_role != 3, function ($q) {
                return $q->forCompany(Auth::user()->company_id);
            })
            ->when($parentCode, function ($q) use ($parentCode) {
                return $q->where('parent_code', $parentCode);
            })
            ->when($level, function ($q) use ($level) {
                return $q->where('level', $level);
            })
            ->orderBy('account_code')
            ->get(['id', 'account_code', 'account_name']);

        return response()->json($accounts);
    }

    public function getMovementAccounts()
    {
        $accounts = PucAccount::active()
            ->movementAccounts()
            ->when(Auth::user()->is_role != 3, function ($q) {
                return $q->forCompany(Auth::user()->company_id);
            })
            ->orderBy('account_code')
            ->get(['id', 'account_code', 'account_name', 'nature']);

        return response()->json($accounts);
    }

    private function authorizeAccess(PucAccount $pucAccount)
    {
        if (Auth::user()->is_role != 3 && $pucAccount->company_id != Auth::user()->company_id) {
            abort(403, 'No tienes permisos para acceder a esta cuenta.');
        }
    }
}
