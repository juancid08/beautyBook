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
        Schema::create('cadena_salon', function (Blueprint $table) {
            $table->id('id_cadena_salon');
            $table->string('nombre');
            $table->string('direccion_central');
            $table->string('telefono');
            $table->string('correo_contacto');
            $table->string('website');
            $table->text('descripcion');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadena_salon');
    }
};
