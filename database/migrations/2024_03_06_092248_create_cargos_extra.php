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
        Schema::create('cargosextras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained()->onDelete('cascade');
            $table->string('concepto')->nullable();
            $table->decimal('valor20', 8, 2)->nullable();
            $table->decimal('valor40', 8, 2)->nullable();
            $table->decimal('valorHQ', 8, 2)->nullable();
            $table->string('Unidad')->nullable();
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
        Schema::dropIfExists('cargosextras');
    }
};
