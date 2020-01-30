<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalibesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talibes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dieuw_id')->nullable();
            $table->integer('daara_id');
            $table->string('prenom');
            $table->string('nom');
            $table->boolean('genre');
            $table->string('avatar')->nullable();
            $table->string('pere')->nullable();
            $table->string('mere')->nullable();
            
            $table->date('datenaissance')->nullable();
            $table->string('lieunaissance')->nullable();
            $table->string('adresse')->nullable();
            $table->string('tuteur')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('region')->nullable();

            $table->integer('niveau')->nullable();
            $table->date('arrivee')->nullable();
            $table->date('depart')->nullable();
            $table->date('deces')->nullable();
            $table->text('commentaire')->nullable();

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
        Schema::dropIfExists('talibes');
    }
}
