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
        Schema::create('servicio', function (Blueprint $table) {
            $table->id('id_servicio');
            $table->string('nombre');
            $table->string('descripcion');
            $table->float('precio');
            $table->integer('duracion');

            # Clave FK de salon
            $table->foreign('id_salon')->constrained('salon','id_salon')
            ->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio');
    }
};
