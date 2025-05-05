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
        Schema::create('salon', function (Blueprint $table) {
            $table->id('id_salon');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('horario_apertura');
            $table->string('horario_cierre');
            $table->string('descripcion');
            $table->string('foto');


            # Clave FK de salon
            $table->foreign('id_cadena_salon')->constrained('cadena_salon','id_cadena_salon')
            ->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salon');
    }
};
