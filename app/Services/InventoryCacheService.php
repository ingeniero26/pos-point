<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class InventoryCacheService
{
    /**
     * Limpiar el caché de inventario de la empresa
     * (Solución universal: limpia todo el caché)
     */
    public function clearInventoryCache($companyId)
    {
        // Solución universal: limpiar todo el caché (¡afecta toda la app!)
        Cache::flush();
    }
} 