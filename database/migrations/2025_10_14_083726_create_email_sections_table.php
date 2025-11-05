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
        Schema::create('email_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emailid')->constrained('emails')->onDelete("cascade");
            $table->foreignId('sectionid')->constrained('sections')->onDelete("cascade");
            $table->integer('order')->nullable;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_sections');
    }
};
