<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearInventoryCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:clear-cache {--company= : ID de la empresa específica}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar caché de inventario para mejorar el rendimiento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companyId = $this->option('company');
        
        if ($companyId) {
            // Limpiar caché para una empresa específica
            $pattern = "inventory_{$companyId}_*";
            $this->clearCacheByPattern($pattern);
            $this->info("Caché de inventario limpiado para la empresa ID: {$companyId}");
        } else {
            // Limpiar todo el caché de inventario
            $pattern = "inventory_*";
            $this->clearCacheByPattern($pattern);
            $this->info('Caché de inventario limpiado para todas las empresas');
        }
    }

    /**
     * Limpiar caché por patrón
     */
    private function clearCacheByPattern($pattern)
    {
        $keys = Cache::get($pattern);
        if ($keys) {
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        }
        
        // También limpiar estadísticas de inventario
        Cache::forget('inventory_stats_*');
    }
} 