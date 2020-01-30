<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daaras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->decimal('lat')->nullable();
            $table->decimal('lon')->nullable();
            $table->date('creation')->nullable();
            $table->string('dieuw');
            $table->string('image')->nullable();
            $table->string('phone');
            $table->softDeletes();
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
        Schema::dropIfExists('daaras');
    }
}
