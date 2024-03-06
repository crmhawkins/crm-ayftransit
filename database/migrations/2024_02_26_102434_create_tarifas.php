<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->integer('origen_id')->nullable();
            $table->integer('destino_id')->nullable();
            $table->string('destinoterrestre')->nullable();
            $table->double('precio_contenedor_20')->nullable();
            $table->double('precio_contenedor_40')->nullable();
            $table->double('precio_contenedor_h4')->nullable();
            $table->double('precio_terrestre')->nullable();
            $table->double('precio_grupage')->nullable();
            $table->integer('tipo_imp_exp')->nullable();
            $table->integer('tipo_cont_grup')->nullable();
            $table->integer('tipo_mar_area_terr')->nullable();
            $table->integer('proveedor_id')->nullable();
            $table->string('dias')->nullable();
            $table->date('validez')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarifas');
    }
};
