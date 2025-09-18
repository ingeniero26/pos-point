<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use App\Models\Companies;
use App\Models\IdentificationTypeModel;
use App\Models\CountryModel;
use App\Models\DepartmentModel;
use App\Models\CityModel;
use App\Models\CurrenciesModel;
use App\Models\TypeLiabilityModel;
use App\Models\TypeRegimenModel;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {   
        $company = Companies::first();
        $businessTypes = BusinessType::all()->pluck('name', 'id');
        $identification_types = IdentificationTypeModel::all()->pluck('identification_name', 'id');
        $countries = CountryModel::all()->pluck('country_name', 'id');
        $departments = DepartmentModel::all()->pluck('name_department', 'id');
        $cities = CityModel::all()->pluck('city_name', 'id');
        $currencies = CurrenciesModel::all()->pluck('currency_name', 'id');
        $type_regimens = TypeRegimenModel::all()->pluck('regimen_name', 'id');
        $type_obligation = TypeLiabilityModel::all()->pluck('liability_name', 'id');

        return view('admin.companies.edit', compact(
            'company',
            'businessTypes',
            'identification_types',
            'countries',
            'departments',
            'cities',
            'currencies',
            'type_regimens',
            'type_obligation'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'busines_type_id' => 'required|exists:business_types,id',
            'identification_type_id' => 'required|exists:identification_type,id',
            'identification_number' => 'required|string|max:250',
            'dv' => 'required|string|max:250',
            'company_name' => 'required|string|max:250',
            'short_name' => 'nullable|string|max:250',
            'trade_name' => 'nullable|string|max:250',
            'ciiu_code' => 'nullable|string|max:250',
            'activity_description' => 'nullable|string|max:500',
            'cc_representative' => 'nullable|string|max:250',
            'email' => 'required|email|max:250',
            'legal_representative' => 'nullable|string|max:250',
            'country_id' => 'required|exists:countries,id',
            'department_id' => 'required|exists:departments,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:250',
            'phone' => 'required|string|max:250',
            'currency_id' => 'required|exists:currencies,id',
            'type_regimen_id' => 'required|exists:type_regimen,id',
            'economic_activity_code' => 'nullable|string|max:250',
            'ica_rate' => 'nullable|string|max:250',
            'type_obligation_id' => 'nullable|integer',
            'dian_resolution' => 'nullable|string|max:250',
            'invoice_prefix' => 'nullable|string|max:250',
            'resolution_date' => 'nullable|date',
            'current_consecutive' => 'nullable|string|max:250',
            'range_from' => 'nullable|string|max:250',
            'range_to' => 'nullable|string|max:250',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'environment' => 'nullable|string|max:250',
        
        ]);

        $company = Companies::findOrFail($id);
        $company->update($request->all());

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/company_logos'), $filename);
            $company->logo = 'uploads/company_logos/' . $filename;
            $company->save();
        }

        return redirect()->back()->with('success', 'Información de la empresa actualizada exitosamente');
    }
}
