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
        Schema::create('estaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipalidad_id')->constrained('municipalidades')->onDelete('restrict');
            $table->string('nombre');
            $table->unsignedInteger('capacidad_maxima')->default(500);
            $table->unsignedInteger('ocupacion_actual')->default(0);
            $table->timestamps();
            $table->index('municipalidad_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estaciones');
    }
};
