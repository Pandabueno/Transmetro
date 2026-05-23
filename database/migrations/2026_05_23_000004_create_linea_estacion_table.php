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
        Schema::create('linea_estacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('linea_id')->constrained('lineas')->onDelete('cascade');
            $table->foreignId('estacion_id')->constrained('estaciones')->onDelete('cascade');
            $table->unsignedInteger('orden')->default(1);
            $table->decimal('distancia', 8, 2)->default(0);
            $table->timestamps();
            $table->index('linea_id');
            $table->index('estacion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea_estacion');
    }
};
