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
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estacion_id')->constrained('estaciones')->onDelete('cascade');
            $table->string('tipo')->default('ocupacion');
            $table->dateTime('fecha_hora');
            $table->boolean('atendida')->default(false);
            $table->foreignId('atendida_por')->nullable()->constrained('operadores')->onDelete('set null');
            $table->timestamps();
            $table->index('estacion_id');
            $table->index('atendida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
