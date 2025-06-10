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
        Schema::create('academias_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academiaid')->constrained('academias')->onDelete('cascade');
            $table->foreignId('clienteid')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('alumnoid')->nullable()->constrained('alumnos')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_academias');
    }
};
