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
        Schema::create('horario_estacion', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_estacion')->nullable();
            $table->unsignedBigInteger('id_horario')->nullable();

            $table->foreign('id_estacion')->references('id')->on('estacion')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');

            $table->foreign('id_horario')->references('id')->on('horario')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_estacion');
    }
};
