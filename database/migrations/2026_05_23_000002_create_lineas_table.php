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
        Schema::create('lineas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipalidad_id')->constrained('municipalidades')->onDelete('restrict');
            $table->string('nombre')->unique();
            $table->decimal('distancia_total', 8, 2)->default(0);
            $table->unsignedInteger('cantidad_buses')->default(0);
            $table->timestamps();
            $table->index('municipalidad_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineas');
    }
};
