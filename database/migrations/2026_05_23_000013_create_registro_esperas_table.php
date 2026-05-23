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
        Schema::create('registro_esperas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->foreignId('estacion_id')->constrained('estaciones')->onDelete('cascade');
            $table->dateTime('fecha_hora');
            $table->unsignedInteger('minutos_espera')->default(5);
            $table->timestamps();
            $table->index('bus_id');
            $table->index('estacion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_esperas');
    }
};
