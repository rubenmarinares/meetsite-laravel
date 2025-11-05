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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // nombre de la plantilla o del email
            $table->string("type"); // 1 si es plantilla, 0 si es email
            $table->integer("order"); 
            $table->integer("status")->default(1);
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }


    /*
        Existirán secciones de distintos tipos:
        - 100%        
        -2 columnas
        -3 columnas
        -4 columnas

    */
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
