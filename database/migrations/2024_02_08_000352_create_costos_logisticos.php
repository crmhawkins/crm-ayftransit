<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('costos_logisticos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operacion_id')->constrained('operaciones');
            $table->enum('tipo', ['flete', 'ens', 'q', 'manipulaciones', 'descarga']);
            $table->decimal('valor', 8, 2);
            $table->string('puerto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('costos_logisticos');
    }
};
