<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAttributeOrdonnance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordonnances', function (Blueprint $table) {
            $table->integer('medecin_id')->change()->nullable(true);
            $table->text('commentaire')->change()->nullable(true);
            $table->date('date_ordonnance')->change()->nullable(true);
            $table->string('nom_ordonnance')->change()->nullable(true);
            $table->integer('talibe_id')->change()->nullable(true);
            $table->string('nom_hopital')->change()->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
