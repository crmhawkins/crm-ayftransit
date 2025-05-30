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
            $table->dropColumn("id_evento");
            $table->dropColumn("id_cliente");
            $table->dropColumn("precioBase");
            $table->dropColumn("precioFinal");
            $table->dropColumn("descuento");
            $table->dropColumn("adelanto");
            $table->dropColumn("observaciones");
            $table->dropColumn("fechaEmision");


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
            $table->bigInteger("id_evento");
            $table->bigInteger("id_cliente");
            $table->float("precioBase");
            $table->float("precioFinal");
            $table->integer("descuento");
            $table->integer("adelanto");
            $table->text("observaciones");
            $table->date("fechaEmision");
        });
    }
};
