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
            $table->id('id_cita');
            $table->date('fecha');
            $table->string('estado');
            $table->string('hora');

            # Clave FK de usuario
            $table->foreignId('id_usuario')->constrained('usuario','id_usuario')
            ->onDelete('cascade')->nullable();

            # Clave FK de servicio
            $table->foreignId('id_servicio')->constrained('servicio','id_servicio')
            ->onDelete('cascade')->nullable();

            # Clave FK de empleado
            $table->foreignId('id_empleado')->constrained('empleado','id_empleado')
            ->onDelete('cascade')->nullable();
            
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
