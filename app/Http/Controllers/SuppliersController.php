<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\DepartmentModel;
use App\Models\IdentificationTypeModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use DB;

class SuppliersController extends Controller
{
    //
    public function index()
    {
        $identification_type = IdentificationTypeModel::all()->pluck('identification_name','id');
        $departments = DepartmentModel::all()->pluck('name_department','id');
        $cities = CityModel::all()->pluck('city_name', 'id');
        return view('admin.supplier.list',compact('identification_type','departments','cities'));
       // return view('admin.supplier.list');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'company_name' =>'required',
            'identification_type_id' =>'required',
            'identification_number' =>'required|unique:customers,identification_number',
            'address' =>'required',
            'phone' =>'required',
            'email' =>'required|email|unique:customers,email',
            'city_id' =>'required',
            'department_id' =>'required',
        ]);

        // Create a new customer
        $customer = new SupplierModel();
        $customer->identification_type_id = $request->identification_type_id;
        $customer->identification_number = $request->identification_number;
        $customer->company_name = $request->company_name;
        $customer->contact_name = $request->contact_name;
        $customer->contact_last_name = $request->contact_last_name;
        $customer->type_person = $request->type_person;
        $customer->tax_liability = $request->tax_liability;
        $customer->city_id = $request->city_id;
        $customer->department_id = $request->department_id;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
       
        $customer->created_by = Auth::user()->id;
        $customer->save();
        if ($request->comment)
        { \DB::table('supplier_comments')->insert([ 'supplier_id' => 
           $customer->id, 
           'comment' => $request->comment,

       ]); 
       }
       //comment

       return response()->json(['success' => 'Registro Creado con Éxito']);
    }

    public function getSuppliers(Request $request)
    {
        $query = SupplierModel::with(['identification_type', 'departments', 'cities']);
    
        // Filtros para el tipo de contacto
        // if ($request->has('type_contact') && $request->type_contact != '') {
        //     $query->where('type_contact', $request->type_contact);
        // }
    
        // Filtros para el estado
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
    
        // Filtros para la fecha de creación
        // if ($request->has('start_date') && $request->has('end_date')) {
        //     $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        // }
    
        $supplier = $query->get();
        return response()->json($supplier);
    }
    public function edit($id)
    {
        $supplier = SupplierModel::findOrFail($id);
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'company_name' =>'required',
            'identification_type_id' =>'required',
            'identification_number' =>'required|unique:customers,identification_number,'.$id,
            'address' =>'required',
            'phone' =>'required',
            'email' =>'required|email|unique:customers,email,'.$id,
            'city_id' =>'required',
            'department_id' =>'required',
        ]);

        // Update the customer
        $customer = SupplierModel::find($id);
        $customer->identification_type_id = $request->identification_type_id;
        $customer->identification_number = $request->identification_number;
        $customer->company_name = $request->company_name;
        $customer->contact_name = $request->contact_name;
        $customer->contact_last_name = $request->contact_last_name;
        $customer->type_person = $request->type_person;
        $customer->tax_liability = $request->tax_liability;
        $customer->city_id = $request->city_id;
        $customer->department_id = $request->department_id;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        //$customer->updated_by = Auth::user()->id;
        $customer->save();
        //comment

    }
    public function show($id) { 
        $supplier = SupplierModel::with('departments', 'cities', 'identification_type')->find($id);
         if ($supplier) { 
            return view('admin.supplier.show', compact('supplier')); } 
            else { 
                return redirect()->route('admin.supplier.list')->with('error', 'Proveedor no encontrado.'); 
            } 
        }

    public function destroy($id)
    {
        $supplier = SupplierModel::find($id);
        $supplier->delete();
        return response()->json(['success' => 'Registro Eliminado con Éxito']);
    }
    public function getSupplierComments($id)
    {
        $supllier_comments = DB::table('supplier_comments')->where('supplier_id', $id)->get();
        return response()->json($supllier_comments);
    }
    public function toggleStatus(Request $request, $id)
    {
        $supplier = SupplierModel::find($id);
        if ($supplier) {
            $supplier->status = $request->status;
            $supplier->save();
            return response()->json(['success' => 'Estado cambiado exitosamente.']);
        } else {
            return response()->json(['error' => 'Proveedor no encontrada.'], 404);
        }
    }
    public function checkEmail(Request $request)
    {
        $email = request('email');
        $customer = SupplierModel::where('email', $email)->first();
        if ($customer) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }


    public function sendEmail(Request $request, $id) { $supplier = SupplierModel::findOrFail($id);
         if (!$supplier)
         {
             return response()->json(['success' => false, 'error' => 'Proveedor no encontrado.'], 404);
         } 
         $subject = $request->input('subject');
          $body = $request->input('body');
          Mail::raw($body, function ($message) use ($supplier, $subject)
           { $message->to($supplier->email) ->subject($subject); });
            return response()->json(['success' => true]); }
}