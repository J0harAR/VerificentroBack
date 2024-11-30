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
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->string('placa')->primary();
            $table->string('vin');
            $table->string('modelo');
            $table->string('marca');
            $table->year('año');
            $table->string('estado');
            $table->string('tipo_combustible');
            // Clave foránea hacia solicitante
            $table->string('id_solicitante');
            $table->foreign('id_solicitante')->references('curp')->on('solicitante')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
    }
};
