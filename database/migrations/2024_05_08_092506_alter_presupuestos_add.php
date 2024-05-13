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
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->date("fechaEmision")->nullable();
            $table->Integer("id_cliente")->nullable();
            $table->integer("tipo_imp_exp")->nullable();
            $table->integer("tipo_cont_grup")->nullable();
            $table->integer("tipo_mar_area_terr")->nullable();
            $table->integer("destino")->nullable();
            $table->integer("id_proveedorterrestre")->nullable();
            $table->double("precio_terrestre")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn("fechaEmision")->nullable();
            $table->dropColumn("id_cliente")->nullable();
            $table->dropColumn("tipo_imp_exp")->nullable();
            $table->dropColumn("tipo_cont_grup")->nullable();
            $table->dropColumn("tipo_mar_area_terr")->nullable();
            $table->dropColumn("destino")->nullable();
            $table->dropColumn("id_proveedorterrestre")->nullable();
            $table->dropColumn("precio_terrestre")->nullable();
        });
    }
};
