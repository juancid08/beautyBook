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
        Schema::create('notificacion', function (Blueprint $table) {
            $table->id('id_notificacion');
            $table->string('mensaje');
            $table->date('fecha_envio');
            $table->string('tipo');
            $table->string('estado');
            $table->timestamps();

            # Clave FK de usuario
            $table->foreign('id_usuario')->constrained('usuario','id_usuario')
                  ->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacion');
    }
};
