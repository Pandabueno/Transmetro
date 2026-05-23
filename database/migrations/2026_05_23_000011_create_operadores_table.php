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
        Schema::create('operadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estacion_id')->nullable()->constrained('estaciones')->onDelete('set null');
            $table->string('nombre');
            $table->string('usuario')->unique();
            $table->string('password');
            $table->enum('rol', ['admin', 'operador', 'supervisor']);
            $table->timestamps();
            $table->index('estacion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operadores');
    }
};
