<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Companies extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'identification_type_id',
        'identification_number',
        'company name',
        'short_name',
        'trade_name', // New field added for trade name
        'code_ciiu', // New field added for CIIU code
        'activity_description',
        'legal_representative',
        'cc_representative',
        'email',
        'logo',
        'country_id',
        'department_id',
        'city_id',
        'address',
        'phone',
        'currency_id',
        'type_regimen_id',
        'economic_activity_code',
        'ica_rate',
        'type_obligation_id',
        'dian_resolution',
        'invoice_prefix',
        'resolution_date',
        'date_from',
        'date_to',
        'current_consecutive',
        'range_from',
        'range_to',
        
        'environment', // New field added for environment
        'dv', // Added field for digit verification

    ];

   
         protected $casts = [
        'resolution_date' => 'date',
        'date_from' => 'date',
        'date_to' => 'date',
        'range_from' => 'integer',
        'range_to' => 'integer',
        'current_consecutive' => 'integer'
    ];

    // obtener el consecutivo de la factura
     /**
     * Generar el siguiente consecutivo de forma segura
     */
    public function getNextConsecutive()
    {
        // Usar transacción para evitar condiciones de carrera
        return DB::transaction(function () {
            // Bloquear el registro para actualización
            $company = self::lockForUpdate()->find($this->id);
            
            // Verificar que no exceda el rango permitido
            if ($company->current_consecutive >= $company->range_to) {
                throw new \Exception("Se ha alcanzado el límite máximo de consecutivos ({$company->range_to})");
            }
            
            // Incrementar el consecutivo
            $nextConsecutive = $company->current_consecutive + 1;
            
            // Actualizar en la base de datos
            $company->update(['current_consecutive' => $nextConsecutive]);
            
            return $nextConsecutive;
        });
    }
      /**
     * Inicializar el consecutivo si es null
     */
    public function initializeConsecutive()
    {
        if (is_null($this->current_consecutive)) {
            $this->update(['current_consecutive' => $this->range_from]);
        }
    }

    /**
     * Obtener el consecutivo formateado con prefijo
     */
    public function getFormattedConsecutive($consecutive = null)
    {
        $consecutive = $consecutive ?? $this->current_consecutive;
        return $this->invoice_prefix . str_pad($consecutive, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Verificar si el consecutivo está en el rango válido
     */
    public function isConsecutiveInRange($consecutive = null)
    {
        $consecutive = $consecutive ?? $this->current_consecutive;
        return $consecutive >= $this->range_from && $consecutive <= $this->range_to;
    }

    // Relaciones
    // tipo empresa
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'busines_type_id');
    }
    public function identificationType()
    {
        return $this->belongsTo(IdentificationTypeModel::class, 'identification_type_id');
    }

    public function country()
    {
        return $this->belongsTo(CountryModel::class, 'country_id');
    }

    public function department()
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id');
    }

    public function city()
    {
        return $this->belongsTo(CityModel::class, 'city_id');
    }

    public function currency()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }

    public function typeRegimen()
    {
        return $this->belongsTo(TypeRegimenModel::class, 'type_regimen_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(PurchaseModel::class);
    }
}
