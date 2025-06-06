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
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('empresa');
            $table->string('cif');
            $table->string('seguro')->nullable();
            $table->string('pago')->nullable();
            $table->string('origenes')->nullable();
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
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('empresa');
            $table->dropColumn('cif');
            $table->dropColumn('seguro');
            $table->dropColumn('pago');
        });
    }
};
