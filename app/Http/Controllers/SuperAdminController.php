<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    /**
     * Display super admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::admins()->count(),
            'total_super_admins' => User::superAdmins()->count(),
            'total_companies' => Companies::count(),
            'active_users' => User::active()->count(),
        ];

        return view('super_admin_dashboard.list', compact('stats'));
    }

    /**
     * Display list of all users
     */
    public function users()
    {
        return view('super_admin.users.list');
    }

    /**
     * Get users data for DataTable
     */
    public function getUsersData(Request $request)
    {
        $query = User::with('company')
            ->where('is_delete', 0)
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->has('role') && !empty($request->role)) {
            $query->where('is_role', $request->role);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('company_id') && !empty($request->company_id)) {
            $query->where('company_id', $request->company_id);
        }

        $users = $query->get();

        return response()->json($users);
    }

    /**
     * Show form to create super admin
     */
    public function createSuperAdmin()
    {
        $companies = Companies::where('is_delete', 0)->get();
        return view('super_admin.users.create_super_admin', compact('companies'));
    }

    /**
     * Store new super admin
     */
    public function storeSuperAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'company_id' => 'required|exists:companies,id',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_role' => User::ROLE_SUPER_ADMIN,
                'status' => User::STATUS_ACTIVE,
                'company_id' => $request->company_id,
            ]);

            return redirect()
                ->route('super.users.list')
                ->with('success', 'Super Administrador creado exitosamente.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el Super Administrador: ' . $e->getMessage());
        }
    }

    /**
     * Show form to edit user
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $companies = Companies::where('is_delete', 0)->get();
        $roles = User::getRoles();

        return view('super_admin.users.edit', compact('user', 'companies', 'roles'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|min:8|confirmed',
            'is_role' => 'required|in:1,2,3',
            'status' => 'required|in:0,1',
            'company_id' => 'required|exists:companies,id',
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'is_role' => $request->is_role,
                'status' => $request->status,
                'company_id' => $request->company_id,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()
                ->route('super.users.list')
                ->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Delete user (soft delete)
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting the current user
            if ($user->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes eliminar tu propio usuario.'
                ], 400);
            }

            $user->update(['is_delete' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle user status
     */
    public function toggleUserStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deactivating the current user
            if ($user->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes cambiar el estado de tu propio usuario.'
                ], 400);
            }

            $user->update([
                'status' => $user->status == 1 ? 0 : 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Estado del usuario actualizado exitosamente.',
                'new_status' => $user->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create first super admin (for initial setup)
     */
    public function createFirstSuperAdmin(Request $request)
    {
        // Check if any super admin already exists
        if (User::superAdmins()->exists()) {
            return redirect('/')->with('error', 'Ya existe un Super Administrador en el sistema.');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ]);

            try {
                // Create or get the first company
                $company = Companies::first();
                if (!$company) {
                    $company = Companies::create([
                        'company_name' => 'Empresa Principal',
                        'nit' => '000000000-0',
                        'address' => 'Dirección Principal',
                        'phone' => '0000000000',
                        'email' => $request->email,
                        'status' => 1,
                        'is_delete' => 0
                    ]);
                }

                $user = User::create([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'is_role' => User::ROLE_SUPER_ADMIN,
                    'status' => User::STATUS_ACTIVE,
                    'company_id' => $company->id,
                ]);

                // Auto login the new super admin
                Auth::login($user);

                return redirect()
                    ->route('super.dashboard')
                    ->with('success', 'Super Administrador creado exitosamente. ¡Bienvenido!');

            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Error al crear el Super Administrador: ' . $e->getMessage());
            }
        }

        return view('auth.create_first_super_admin');
    }
}