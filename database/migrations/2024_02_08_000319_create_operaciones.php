<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('operaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores');
            $table->enum('tipo', ['maritimo', 'aereo', 'terrestre']);
            $table->date('fecha_emision');
            $table->string('referencia_num');
            $table->string('codigo');
            $table->string('bill_of_landing');
            $table->enum('estado', ['despachado', 'en_transito', 'anulado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('operaciones');
    }
};