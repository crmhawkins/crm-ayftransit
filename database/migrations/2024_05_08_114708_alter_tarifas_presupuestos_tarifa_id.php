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
        Schema::table('tarifas_presupuestos', function (Blueprint $table) {
            $table->integer("tarifa_id")->nullable();
            $table->date("validez")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarifas_presupuestos', function (Blueprint $table) {
            $table->dropColumn("tarifa_id");
            $table->dropColumn("validez");

        });
    }
};
