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
        Schema::table('proveedores', function (Blueprint $table) {
            $table->string('contacto')->nullable();
            $table->double('gastos_llegada_20',20,2)->nullable();
            $table->double('gastos_llegada_40',20,2)->nullable();
            $table->double('gastos_llegada_h4',20,2)->nullable();
            $table->double('gastos_llegada_grupage',20,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->dropColumn('contacto');
            $table->dropColumn('gastos_llegada');
        });
    }
};
