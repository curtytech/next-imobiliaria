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
        Schema::table('imovels', function (Blueprint $table) {
            $table->decimal('area_util', 8, 2)->nullable();
            $table->decimal('terreno', 8, 2)->nullable();
            $table->decimal('area_constr', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imovels', function (Blueprint $table) {
            $table->dropColumn(['area_util', 'terreno', 'area_constr']);
        });
    }
};
