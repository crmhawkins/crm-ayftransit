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
            $table->double("gastos_llegada_20")->nullable();
            $table->double("gastos_llegada_40")->nullable();
            $table->double("gastos_llegada_h4")->nullable();
            $table->double("gastos_llegada_grupage")->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preuspuestos', function (Blueprint $table) {
            $table->dropColumn("gastos_llegada_20");
            $table->dropColumn("gastos_llegada_40");
            $table->dropColumn("gastos_llegada_h4");
            $table->dropColumn("gastos_llegada_grupage");
        });
    }
};
