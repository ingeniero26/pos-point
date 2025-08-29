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
        Schema::create('accounting_accounts', function (Blueprint $table) {
            $table->string('account_id', 10)->primary();
            $table->integer('company_id')->nullable();
            $table->string('account_name', 255);
            $table->tinyInteger('level');
            $table->string('parent_account', 10)->nullable();
            $table->enum('account_type', ['ASSETS', 'LIABILITIES', 'EQUITY', 'INCOME', 'EXPENSES', 'COSTS']);
            $table->enum('nature', ['DEBIT', 'CREDIT']);
            $table->boolean('allow_movement')->default(1);
            $table->boolean('requires_third_party')->default(0);
            $table->boolean('requires_cost_center')->default(0);
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->text('comments')->nullable();
            
            // Índices
            $table->index('parent_account', 'parent_account_idx');
            $table->index('account_type', 'account_type_idx');
            $table->index('level', 'level_idx');
            
            // Restricciones de clave foránea
            $table->foreign('parent_account', 'accounting_accounts_ibfk_1')
                  ->references('account_id')
                  ->on('accounting_accounts')
                  ->onUpdate('RESTRICT')
                  ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_accounts');
    }
};