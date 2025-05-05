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
            $table->foreign('id_usuario')->constrained('usuario','id_usuario')
            ->onDelete('cascade');

            # Clave FK de servicio
            $table->foreign('id_servicio')->constrained('servicio','id_servicio')
            ->onDelete('cascade');

            # Clave FK de empleado
            $table->foreign('id_empleado')->constrained('empleado','id_empleado')
            ->onDelete('cascade');
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
