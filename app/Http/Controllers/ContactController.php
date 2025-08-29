<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\ContactModel;
use App\Models\DepartmentModel;
use App\Models\IdentificationTypeModel;

class ContactController extends Controller
{
    public function list()
    {
        $identification_type = IdentificationTypeModel::all()->pluck('identification_name','id');
        $departments = DepartmentModel::all()->pluck('name_department','id');
        $cities = CityModel::all()->pluck('city_name', 'id');
        return view('admin.contact.list', compact('identification_type','departments','cities'));

    }
    public function store(Request $request)
    {
        $request->validate([
           
            'identification_type_id' =>'required|integer',
            'identification_number' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:contacts',
           
            'department_id' =>'required|integer',
            'city_id' =>'required|integer',
            'address' =>'required|string|max:255',
        ]);

        $contact = new ContactModel();
        $contact->type_contact = $request->type_contact;
        $contact->identification_type_id = $request->identification_type_id;
        $contact->identification_number = $request->identification_number;
        $contact->company_name = $request->company_name;
        $contact->contact_name = $request->contact_name;
        $contact->contact_last_name = $request->contact_last_name;
        $contact->type_person = $request->type_person;
        $contact->tax_liability = $request->tax_liability;
        $contact->department_id = $request->department_id;
        $contact->city_id = $request->city_id;
        $contact->address = $request->address;
        $contact->phone = $request->phone;

        $contact->email = $request->email;
        $contact->save();

        if ($request->comment)
         { \DB::table('contact_comments')->insert([ 'contact_id' => 
            $contact->id, 
            'comment' => $request->comment,
 
        ]); 
        }
        //comment

        return response()->json(['success' => 'Registro Creado con Éxito']);
    }



public function getContact(Request $request)
{
    $query = ContactModel::with(['identification_type', 'departments', 'cities']);

    // Filtros para el tipo de contacto
    if ($request->has('type_contact') && $request->type_contact != '') {
        $query->where('type_contact', $request->type_contact);
    }

    // Filtros para el estado
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Filtros para la fecha de creación
    // if ($request->has('start_date') && $request->has('end_date')) {
    //     $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    // }

    $contacts = $query->get();
    return response()->json($contacts);
}
	
      public function toggleStatus(Request $request, $id)
      {
          $contact = ContactModel::find($id);
          if ($contact) {
              $contact->status = $request->status;
              $contact->save();
              return response()->json(['success' => 'Estado cambiado exitosamente.']);
          } else {
              return response()->json(['error' => 'Contacto no encontrada.'], 404);
          }
      }
      public function edit($id)
      {
        $contact = ContactModel::findOrFail($id);
        return response()->json($contact);
      }
      public function update(Request $request, $id)
      {
        $request->validate([
            'identification_type_id' =>'required|integer',
            'identification_number' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:contacts,email,'.$id,
            'department_id' =>'required|integer',
            'city_id' =>'required|integer',
            'address' =>'required|string|max:255',
        ]);

        $contact = ContactModel::find($id);
        $contact->type_contact = $request->type_contact;
        $contact->identification_type_id = $request->identification_type_id;
        $contact->identification_number = $request->identification_number;
        $contact->company_name = $request->company_name;
        $contact->contact_name = $request->contact_name;
        $contact->contact_last_name = $request->contact_last_name;
        $contact->type_person = $request->type_person;
        $contact->tax_liability = $request->tax_liability;
        $contact->department_id = $request->department_id;
        $contact->city_id = $request->city_id;
        $contact->address = $request->address;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->save();

        // comentario
        
      }
   
      public function destroy($id)
      {
        $contact = ContactModel::find($id);
        if ($contact) {
            $contact->delete();
            return response()->json(['success' => 'Contacto eliminado exitosamente.']);
        } else {
            return response()->json(['error' => 'Contacto no encontrado.'], 404);
        }
      }

      public function show($id) { 
        $contact = ContactModel::with('departments', 'cities', 'identification_type')->find($id);
         if ($contact) { 
            return view('admin.contact.show', compact('contact')); } 
            else { 
                return redirect()->route('admin.contact.list')->with('error', 'Cliente no encontrado.'); 
            } 
        }
}


