<?php

namespace App\Http\Controllers;

use App\Models\AccountBankModel;
use App\Models\AccountTypesModel;
use App\Models\BankingInstitutionsModel;
use App\Models\CurrenciesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountBankController extends Controller
{
    //
    public function list()
    {
        $banks = BankingInstitutionsModel::all()->pluck('name','id');
        $account_types = AccountTypesModel::all()->pluck('account_type','id');
        $currencies = CurrenciesModel::all()->pluck('currency_name','id');

        return view('admin.account_bank.list',compact('banks','account_types','currencies'));
    }
    public function getBankAccounts() {
        $account_bank = AccountBankModel::with(['banks','account_types','currencies'])
            ->get();
            return response()->json($account_bank);
    }
    public function store(Request $request) 
    {
        $request->validate([
            'number' => 'required|unique:bank_accounts,number',
            'bank_id' => 'required|exists:banks,id',
            'account_type_id' => 'required|exists:account_types,id',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            \DB::beginTransaction();

            $account_bank = new AccountBankModel();
            $account_bank->bank_id = $request->bank_id;
            $account_bank->account_type_id = $request->account_type_id;
            $account_bank->currency_id = $request->currency_id;
            $account_bank->number = $request->number;
            $account_bank->description = $request->description;
            $account_bank->amount = $request->amount;
            // Inicializar los nuevos campos
            $account_bank->available_balance = $request->amount; // El saldo disponible inicial es igual al monto inicial
            $account_bank->reconciled_balance = $request->amount; // El saldo conciliado inicial es igual al monto inicial
            $account_bank->last_reconciliation_date = now(); // Fecha de la primera conciliación
            $account_bank->status = true;
            $account_bank->is_delete = false;
            $account_bank->company_id = Auth::user()->company_id;
            $account_bank->created_by = Auth::user()->id;;

            $account_bank->save();

            // Crear el primer movimiento bancario como saldo inicial
            $bankMovement = new \App\Models\BankMovementModel();
            $bankMovement->bank_account_id = $account_bank->id;
            $bankMovement->type = 'INGRESO';
            $bankMovement->amount = $request->amount;
            $bankMovement->reference = 'Saldo Inicial';
            $bankMovement->description = 'Creación de cuenta bancaria - Saldo inicial';
            $bankMovement->transaction_date = now();
            $bankMovement->is_reconciled = true;
            $bankMovement->reconciliation_date = now();
            $bankMovement->created_by = Auth::user()->id;
            $bankMovement->company_id = Auth::user()->company_id;
            $bankMovement->status = true;
            $bankMovement->is_delete = false;
            
            $bankMovement->save();

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta bancaria creada exitosamente'
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la cuenta bancaria',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function edit($id)
    {
        $account_bank = AccountBankModel::findOrFail($id);
        return response()->json($account_bank);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'number' =>'required|required'
        ]);

        $account_bank = AccountBankModel::find($id);
        $account_bank->bank_id = $request->bank_id;
        $account_bank->account_type_id = $request->account_type_id;
        $account_bank->currency_id = $request->currency_id;
        $account_bank->number = $request->number;
        $account_bank->description = $request->description;
        $account_bank->amount = $request->amount;
        $account_bank->status = $request->status;

        $account_bank->save();

        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroy($id){
        $account_bank = AccountBankModel::find($id);
        $account_bank->delete();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
    //validar duplicado de numero de cuenta 
    
    public function checkNumber(Request $request) {
        $number = request('number');
        $account_number = AccountBankModel::where('number', $number)->first();
        if ($account_number) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
