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
        Schema::create('asistencias', function (Blueprint $table) {
            
            $table->foreignId('grupoid')->constrained('grupos')->onDelete('cascade');
            $table->foreignId('alumnoid')->constrained('alumnos')->onDelete('cascade');
            $table->integer('fecha'); // formato YYYYMMDD
            $table->primary(['grupoid', 'alumnoid', 'fecha']); // clave primaria compuesta
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('asistencias');
    }
};
