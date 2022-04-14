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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->default('');
            $table->string('rotation_period')->default('');
            $table->string('orbital_period')->default('');
            $table->string('diameter')->default('');
            $table->string('climate', 255)->default('');
            $table->string('gravity', 255)->default('');
            $table->string('terrain', 255)->default('');
            $table->string('surface_water', 50)->default('');
            $table->string('population', 50)->default('');

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
        Schema::dropIfExists('planets');
    }
};
