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
        Schema::create('opportunity_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order')->default(1);
            $table->decimal('closing_percentage', 5, 2)->default(0.00);
            $table->string('colour', 7)->nullable();
            $table->boolean('is_closing_stage')->default(false);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('created_by');
            $table->boolean('status')->default(true);
            $table->boolean('is_delete')->default(false);
            $table->timestamps();

            // Índices
            $table->index(['company_id', 'status', 'is_delete']);
            $table->index(['company_id', 'order']);
            $table->index('is_closing_stage');

            // Claves foráneas
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_stages');
    }
};