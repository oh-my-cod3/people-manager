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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planet_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('name', 255)->default('');
            $table->string('height')->default('');
            $table->string('mass')->default('');
            $table->string('hair_color', 50)->default('');
            $table->string('skin_color', 50)->default('');
            $table->string('eye_color', 50)->default('');
            $table->string('birth_year', 10)->default('');
            $table->string('gender', 50)->default('');
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
        Schema::dropIfExists('people');
    }
};
