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
            $table->longText('foto');
            $table->decimal('rating', 2, 1)->nullable();

            $table->enum('especializacion', [
                'Peluquería',
                'Barbería',
                'Salón de uñas',
                'Depilación',
                'Cejas y pestañas'
            ]);

            // migration para añadir la relación
            $table->foreignId('id_usuario')->constrained('usuario', 'id_usuario')->onDelete('cascade')->nullable();

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
