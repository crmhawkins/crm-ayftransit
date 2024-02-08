<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->date('fecha_emision');
            $table->enum('tipo_cotizacion', ['maritimo', 'aereo']);
            $table->string('tipo');
            $table->string('naviera_co_loader');
            $table->string('origen');
            $table->string('destino');
            $table->date('valido_desde');
            $table->date('valido_hasta');
            $table->enum('estado', ['activo', 'aceptado', 'rechazado', 'caducado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ofertas');
    }
};