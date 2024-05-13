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
        Schema::create('tarifas_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained()->onDelete('cascade');
            $table->integer('origen_id')->nullable();
            $table->integer('destino_id')->nullable();
            $table->decimal('precio_grupage', 8, 2)->nullable();
            $table->decimal('precio_contenedor_20', 8, 2)->nullable();
            $table->decimal('precio_contenedor_40', 8, 2)->nullable();
            $table->decimal('precio_contenedor_h4', 8, 2)->nullable();
            $table->string('dias')->nullable();
            $table->date('validez')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarifas_presupuestos');
    }
};
