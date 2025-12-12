<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\PersonModel;
use App\Models\DepartmentModel;
use App\Models\IdentificationTypeModel;
use App\Models\TypeLiabilityModel;
use App\Models\TypePersonModel;
use App\Models\TypeRegimenModel;
use App\Models\TypeThirdModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PersonController extends Controller
{
    //
    public function list()
    {
        $identification_type = IdentificationTypeModel::all()->pluck('identification_name','id');
        $departments = DepartmentModel::all()->pluck('name_department','id');
        $cities = CityModel::all()->pluck('city_name', 'id');
        $type_regimen = TypeRegimenModel::all()->pluck('regimen_name', 'id');
        $type_third = TypeThirdModel:: all()->pluck('type_third','id');
        $type_person = TypePersonModel::all()->pluck('type_person', 'id');
        $type_liability = TypeLiabilityModel::all()->pluck('liability_name', 'id');
        $countries = CountryModel::all()->pluck('country_name','id');

        return view('admin.person.list',
        compact('identification_type','departments','cities','type_regimen','type_third',
        'type_person','type_liability','countries'));
    }

   
    public function getCustomers(Request $request)
    {
        $query = PersonModel::with(['identification_type', 'departments',
        'cities','type_regimen','type_third','type_person', 'type_liability','countries']);

        // Filtro por tipo de tercero
        if ($request->has('type_third') && $request->type_third != '') {
            $query->where('type_third_id', $request->type_third);
        }
        // Filtro por tipo de persona
        if ($request->has('type_person') && $request->type_person != '') {
            $query->where('type_person_id', $request->type_person);
        }

        // Filtros para el estado
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        $customer = $query->get();
        return response()->json($customer);
    }


    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            
            'identification_type_id' =>'required',
            'identification_number' =>'required|unique:persons,identification_number',
            'address' =>'required',
           
            'email' =>'required|email|unique:persons,email',
          
        ]);

        // Create a new customer
        $customer = new PersonModel();
        $customer->type_third_id = $request->type_third_id;
        $customer->identification_type_id = $request->identification_type_id;
        $customer->identification_number = $request->identification_number;
        $customer->dv = $request->dv;
        $customer->company_name = $request->company_name;
        $customer->name_trade = $request->name_trade;
        
        $customer->first_name  = $request->first_name;
        $customer->second_name  = $request->second_name;

        $customer->last_name = $request->last_name;
        $customer->second_last_name = $request->second_last_name;
        $customer->type_person_id = $request->type_person_id;
        $customer->type_regimen_id = $request->type_regimen_id;
        $customer->type_liability_id = $request->type_liability_id;
        $customer->ciiu_code = $request->ciiu_code;
        $customer->country_id = $request->country_id;
        $customer->department_id = $request->department_id;
        $customer->city_id = $request->city_id;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
       
        $customer->created_by = Auth::user()->id;
        $customer->save();
        if ($request->comment)
        { \DB::table('customer_comments')->insert([ 'customer_id' => 
           $customer->id, 
           'comment' => $request->comment,

       ]); 
       }
       //comment

       return response()->json(['success' => 'Registro Creado con Éxito']);
    }

    public function checkEmail(Request $request)
    {
        $email = request('email');
        $customer = PersonModel::where('email', $email)->first();
        if ($customer) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    public function checkIdentificationNumber(Request $request)
    {
        $identification_number = request('identification_number');
        $customer = PersonModel::where('identification_number', $identification_number)->first();
        if ($customer) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    public function edit($id)
    {
        $customer = PersonModel::findOrFail($id);
        return response()->json($customer);
    }
    public function update(Request $request, $id)
    {
        $customer = PersonModel::findOrFail($id);
        $request->validate([
            
            'identification_type_id' =>'required',
            'identification_number' =>'required|unique:persons,identification_number,'.$customer->id,
            'address' =>'required',
            'phone' =>'required',
            'email' =>'required|email|unique:persons,email,'.$customer->id,
            'city_id' =>'required',
            'department_id' =>'required',
        ]);

        $customer->identification_type_id = $request->identification_type_id;
        $customer->identification_number = $request->identification_number;
        $customer->dv = $request->dv;
        $customer->company_name = $request->company_name;
        $customer->name_trade = $request->name_trade;
        $customer->first_name  = $request->first_name;
        $customer->second_name  = $request->second_name;
        $customer->last_name = $request->last_name;
        $customer->second_last_name = $request->second_last_name;
        $customer->type_person_id = $request->type_person_id;
        $customer->type_regimen_id = $request->type_regimen_id;
        $customer->type_liability_id = $request->type_liability_id;
        $customer->type_third_id = $request->type_third_id;
        $customer->ciiu_code = $request->ciiu_code;
        $customer->country_id = $request->country_id;
        $customer->city_id = $request->city_id;
        $customer->department_id = $request->department_id;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        //$customer->updated_by = Auth::user()->id;
        $customer->save();
    }

    public function destroy($id)
    {
        $customer = PersonModel::find($id);
        $customer->is_delete = 1;
        $customer->save();
        return response()->json(['success' => 'Registro Eliminado con Éxito']);
    }
    public function getCustomerComments($id)
    {
        $customer_comments = DB::table('customer_comments')->where('customer_id', $id)->get();
        return response()->json($customer_comments);
    }
    public function toggleStatus(Request $request, $id)
    {
        $customer = PersonModel::find($id);
        if ($customer) {
            $customer->status = $request->status;
            $customer->save();
            return response()->json(['success' => 'Estado cambiado exitosamente.']);
        } else {
            return response()->json(['error' => 'Cliente no encontrada.'], 404);
        }
    }
    public function show($id) { 
        $person = PersonModel::with([
            'departments', 
            'cities', 
            'countries',
            'identification_type',
            'type_third',
            'type_person',
            'type_regimen',
            'type_liability',
            'purchases' => function($query) {
                $query->with(['voucher_type', 'state_type', 'payment_method', 'currencies'])
                      ->orderBy('created_at', 'desc')
                      ->limit(10); // Limitar a las últimas 10 compras
            },
            'sales' => function($query) {
                $query->with(['voucherTypes', 'stateTypes', 'payment_method', 'currencies'])
                      ->orderBy('created_at', 'desc')
                      ->limit(10); // Limitar a las últimas 10 ventas
            }
        ])->find($id);
        
        if ($person) { 
            return view('admin.person.show', compact('person')); 
        } else { 
            return redirect()->route('person.list')->with('error', 'Tercero no encontrado.'); 
        } 
    }
    public function checkIdentification()
    {
        $customer = PersonModel::where('identification_number', request('identification_number'))->first();
        if ($customer) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    public function getDepartmentsByCountry(Request $request) {
        $countryId = $request->input('country_id'); // Obtener el ID del país desde la solicitud

        // Obtener los departamentos que pertenecen al país seleccionado
        $departments = DepartmentModel::where('country_id', $countryId)->pluck('name_department', 'id');

        // Devolver los departamentos en formato JSON
        return response()->json(['departments' => $departments]);
    }
    public function getCitiesByDepartment(Request $request) {
        $departmentId = $request->input('department_id'); // Obtener el ID del departamento desde la solicitud
        // Obtener las ciudades que pertenecen al departamento seleccionado
        $cities = CityModel::where('department_id', $departmentId)->pluck('city_name', 'id');
        // Devolver las ciudades en formato JSON
        return response()->json(['cities' => $cities]);
    }


    /**
 * Get person details for AJAX request
 *
 * @param int $id
 * @return \Illuminate\Http\JsonResponse
 */
public function getDetails($id)
{
    try {
        $person = PersonModel::with('identification_type')->findOrFail($id);
        
        return response()->json([
            'id' => $person->id,
            'name' => $person->name,
            'document_type' => $person->identification_type->identification_name ?? '',
            'identification_number' => $person->identification_number,
            'phone' => $person->phone,
            'email' => $person->email,
            'address' => $person->address
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Persona no encontrada'], 404);
    }
}
/**
 * Store a new person via AJAX request
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function storeAjax(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required',
        'identification_type_id' => 'required',
        'identification_number' => 'required|unique:persons,identification_number',
        'phone' => 'nullable',
        'email' => 'nullable|email|unique:persons,email',
        'address' => 'nullable',
    ]);

    // Create a new person
    $person = new PersonModel();
    $person->name = $request->name;
    $person->last_name = $request->last_name;

    $person->identification_type_id = $request->identification_type_id;
    $person->identification_number = $request->identification_number;
    $person->phone = $request->phone;
    $person->email = $request->email;
    $person->address = $request->address;
    $person->type_third_id = $request->type_third_id ?? 1; // Default to customer if not provided
    $person->type_person_id = $request->type_person_id ?? 1; // Default person type
    $person->country_id = $request->country_id ?? 46;
    $person->department_id = $request->department_id ?? 1;
    $person->city_id = $request->city_id ?? 1;
    $person->created_by = Auth::user()->id;
    $person->company_id = Auth::user()->company_id;
    $person->save();

    // Get the identification type name for the response
    $identificationType = IdentificationTypeModel::find($request->identification_type_id);
    $document_type = $identificationType ? $identificationType->identification_name : '';

    return response()->json([
        'success' => true,
        'person' => [
            'id' => $person->id,
            'name' => $person->name,
            'document_type' => $document_type,
            'identification_number' => $person->identification_number,
            'phone' => $person->phone,
            'address' => $person->address
        ]
    ]);
}
    // funcion para listar los person de tipo cliente para el select2
    public function getListPerson()
    {
        $persons = PersonModel::where('type_third_id', 1)->get();
        return response()->json($persons);
    }

}

