<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Índices para la tabla item_warehouse (inventario)
        Schema::table('item_warehouse', function (Blueprint $table) {
            // Índice compuesto para consultas por item y warehouse
            $table->index(['item_id', 'warehouse_id', 'is_delete'], 'idx_item_warehouse_item_warehouse');
            
            // Índice para consultas por empresa
            $table->index(['company_id', 'is_delete'], 'idx_item_warehouse_company');
            
            // Índice para consultas por warehouse
            $table->index(['warehouse_id', 'is_delete'], 'idx_item_warehouse_warehouse');
            
            // Índice para stock bajo
            $table->index(['stock', 'is_delete'], 'idx_item_warehouse_stock');
        });

        // Índices para la tabla item_movements
        Schema::table('item_movements', function (Blueprint $table) {
            // Índice compuesto para historial de movimientos
            $table->index(['item_id', 'warehouse_id', 'is_delete'], 'idx_item_movements_item_warehouse');
            
            // Índice para consultas por empresa
            $table->index(['company_id', 'is_delete'], 'idx_item_movements_company');
            
            // Índice para fechas de movimiento
            $table->index(['movement_date', 'is_delete'], 'idx_item_movements_date');
            
            // Índice para usuario que creó el movimiento
            $table->index(['created_by', 'is_delete'], 'idx_item_movements_user');
        });

        // Índices para la tabla items
        Schema::table('items', function (Blueprint $table) {
            // Índice para búsquedas por nombre
            $table->index(['product_name'], 'idx_items_name');
            
            // Índice para SKU
            $table->index(['sku'], 'idx_items_sku');
            
            // Índice para referencia
            $table->index(['reference'], 'idx_items_reference');
            
            // Índice para categoría
            $table->index(['category_id'], 'idx_items_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover índices de item_warehouse
        Schema::table('item_warehouse', function (Blueprint $table) {
            $table->dropIndex('idx_item_warehouse_item_warehouse');
            $table->dropIndex('idx_item_warehouse_company');
            $table->dropIndex('idx_item_warehouse_warehouse');
            $table->dropIndex('idx_item_warehouse_stock');
        });

        // Remover índices de item_movements
        Schema::table('item_movements', function (Blueprint $table) {
            $table->dropIndex('idx_item_movements_item_warehouse');
            $table->dropIndex('idx_item_movements_company');
            $table->dropIndex('idx_item_movements_date');
            $table->dropIndex('idx_item_movements_user');
        });

        // Remover índices de items
        Schema::table('items', function (Blueprint $table) {
            $table->dropIndex('idx_items_name');
            $table->dropIndex('idx_items_sku');
            $table->dropIndex('idx_items_reference');
            $table->dropIndex('idx_items_category');
        });
    }
}; 