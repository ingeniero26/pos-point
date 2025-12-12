<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonModel extends Model
{
    use SoftDeletes;

    protected $table = 'persons';
    
    protected $fillable = [
        'type_third_id',
        'identification_type_id',
        'identification_number',
        'company_name',
        'name_trade',
        'first_name',
        'second_name',
        'last_name',
        'second_last_name',
        'type_person_id',
        'type_regimen_id',
        'type_liability_id',
        'ciiu_code',
        'country_id',
        'department_id',
        'city_id',
        'address',
        'phone',
        'email',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    
    public function identification_type()
    {
        return $this->belongsTo(IdentificationTypeModel::class, 'identification_type_id');
    }
    public function type_regimen()
    {
        return $this->belongsTo(TypeRegimenModel::class, 'type_regimen_id');
    }
    public function departments() 
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id');
    }

    public function cities()
    {
        return $this->belongsTo(CityModel::class, 'city_id');
    }
    public function type_third() 
    {
        return $this->belongsTo(TypeThirdModel::class, 'type_third_id');
    }
    public function type_person() {
        return $this->belongsTo(TypePersonModel::class, 'type_person_id');
    }
    public function type_liability() 
    {
        return $this->belongsTo(TypeLiabilityModel::class, 'type_liability_id');
    }
    public function countries() {
        return $this->belongsTo(CountryModel::class, 'country_id');
    }

    public function comments()
    {
        return $this->hasMany(CustomerComment::class, 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relación con compras (como proveedor)
    public function purchases()
    {
        return $this->hasMany(PurchaseModel::class, 'supplier_id');
    }

    // Relación con ventas (como cliente)
    public function sales()
    {
        return $this->hasMany(Invoices::class, 'customer_id');
    }

    public function hasRelatedRecords()
    {
        // Verificar si hay registros relacionados en otras tablas
        // Por ejemplo, si hay ventas, compras, etc. asociadas a esta persona
        return $this->purchases()->exists() || $this->sales()->exists();
    }
}
