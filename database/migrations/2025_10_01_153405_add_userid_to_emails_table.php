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
    Schema::table('emails', function (Blueprint $table) {
        $table->unsignedBigInteger('userid')->after('academiaid');

        // Si quieres establecer la relación con users
        $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('emails', function (Blueprint $table) {
        $table->dropForeign(['userid']);
        $table->dropColumn('userid');
    });
}
};
