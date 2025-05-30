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
        Schema::create('resena', function (Blueprint $table) {
            $table->id('id_resena');
            $table->string('comentario');
            $table->integer('calificacion');
            $table->date('fecha_resena');

            # Clave FK de usuario
            $table->foreignId('id_usuario')->constrained('usuario','id_usuario')
            ->onDelete('cascade')->nullable();

            # Clave FK de servicio
            $table->foreignId('id_servicio')->constrained('servicio','id_servicio')
            ->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resena');
    }
};
