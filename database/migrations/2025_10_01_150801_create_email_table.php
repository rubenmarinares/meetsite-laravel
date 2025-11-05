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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('academiaid')->constrained('academias')->onDelete('cascade');            
            $table->string('nombre'); // nombre de la plantilla o del email
            $table->string("plantilla")->default('0'); // 1 si es plantilla, 0 si es email
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
