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
        Schema::create('cita', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->nullable();
            $table->boolean('estado');
            $table->time('hora');
            $table->date('fecha');
            $table->string('tipo');

            $table->string('id_solicitante');
            $table->foreign('id_solicitante')->references('curp')->on('solicitante')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('id_estacion')->nullable();
            $table->foreign('id_estacion')->references('id')->on('estacion')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('id_vehiculo')->nullable();
                $table->foreign('id_vehiculo')->references('placa')->on('vehiculo')
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
        Schema::dropIfExists('cita');
    }
};
