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
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('linea_id')->nullable()->constrained('lineas')->onDelete('set null');
            $table->foreignId('parqueo_id')->constrained('parqueos')->onDelete('restrict');
            $table->string('placa')->unique();
            $table->unsignedInteger('capacidad_max')->default(80);
            $table->timestamps();
            $table->index('linea_id');
            $table->index('parqueo_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
