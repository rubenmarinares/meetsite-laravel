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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('grupo',length:200);
            $table->json('properties')->nullable();
            $table->string('color',length:200);
            $table->integer('fechainicio')->nullable();
            $table->integer('fechafin')->nullable();
            $table->string('textcolor',length:200);
            $table->boolean('status')->default(true);
            $table->integer('fecha')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
