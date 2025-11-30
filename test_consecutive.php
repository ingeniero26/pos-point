<?php
/**
 * Script de prueba para verificar la funcionalidad del método getNextConsecutive
 * 
 * Este script simula la creación de facturas para probar que el consecutivo
 * se genera correctamente y se incrementa secuencialmente.
 */

require_once 'vendor/autoload.php';

// Configurar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Companies;
use App\Models\Invoices;
use Illuminate\Support\Facades\DB;

echo "=== PRUEBA DE FUNCIONALIDAD getNextConsecutive ===\n\n";

try {
    // Obtener la primera empresa disponible
    $company = Companies::first();
    
    if (!$company) {
        echo "❌ No se encontró ninguna empresa en la base de datos.\n";
        exit(1);
    }
    
    echo "🏢 Empresa encontrada: {$company->company_name}\n";
    echo "📋 Prefijo de factura: {$company->invoice_prefix}\n";
    echo "🔢 Rango desde: {$company->range_from}\n";
    echo "🔢 Rango hasta: {$company->range_to}\n";
    echo "📊 Consecutivo actual: {$company->current_consecutive}\n\n";
    
    // Verificar que los rangos estén configurados
    if (is_null($company->range_from) || is_null($company->range_to)) {
        echo "❌ Los rangos de consecutivos no están configurados.\n";
        echo "   Configura range_from y range_to en la tabla companies.\n";
        exit(1);
    }
    
    echo "🧪 Iniciando pruebas de consecutivos...\n\n";
    
    // Probar la generación de consecutivos
    $consecutives = [];
    
    for ($i = 1; $i <= 3; $i++) {
        echo "Prueba {$i}: ";
        
        // Obtener el siguiente consecutivo
        $nextConsecutive = $company->getNextConsecutive();
        $consecutives[] = $nextConsecutive;
        
        // Generar el número de factura formateado
        $formattedInvoice = $company->getFormattedConsecutive($nextConsecutive);
        
        echo "Consecutivo: {$nextConsecutive}, Factura: {$formattedInvoice}\n";
        
        // Verificar que el consecutivo esté en el rango válido
        if (!$company->isConsecutiveInRange($nextConsecutive)) {
            echo "❌ ERROR: El consecutivo {$nextConsecutive} está fuera del rango válido.\n";
            break;
        }
        
        // Pequeña pausa para simular tiempo real
        usleep(100000); // 0.1 segundos
    }
    
    echo "\n📊 Resultados de las pruebas:\n";
    echo "Consecutivos generados: " . implode(', ', $consecutives) . "\n";
    
    // Verificar que los consecutivos sean secuenciales
    $isSequential = true;
    for ($i = 1; $i < count($consecutives); $i++) {
        if ($consecutives[$i] !== $consecutives[$i-1] + 1) {
            $isSequential = false;
            break;
        }
    }
    
    if ($isSequential) {
        echo "✅ Los consecutivos son secuenciales.\n";
    } else {
        echo "❌ ERROR: Los consecutivos no son secuenciales.\n";
    }
    
    // Verificar el estado final de la empresa
    $company->refresh();
    echo "📊 Consecutivo final en la empresa: {$company->current_consecutive}\n";
    
    echo "\n🎉 Pruebas completadas exitosamente!\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📍 Archivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}

