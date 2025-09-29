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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id(); 
            
            $table->foreignId('company_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Campos do colaborador
            $table->string('nome');
            $table->string('telefone');
            $table->string('email');
            
            // Soft Deletes
            $table->softDeletes();
            
            // Timestamps
            $table->timestamps();
            
            // Índices únicos compostos por empresa
            $table->unique(['company_id', 'telefone']);
            $table->unique(['company_id', 'email']);
            
            // Índices para melhor performance
            $table->index('company_id');
            $table->index('email');
            $table->index('telefone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};