<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTalibesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_talibes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('talibe_id')->nullable();
            $table->integer('daara_id')->nullable();
            $table->integer('dieuw_id')->nullable();
            $table->string('hizib_id')->nullable();

            $table->integer('new_talibe_id')->nullable();
            $table->integer('new_daara_id')->nullable();
            $table->integer('new_dieuw_id')->nullable();
            $table->string('new_hizib_id')->nullable();

            $table->boolean('is_change_talibe')->nullable();
            $table->boolean('is_change_hizib')->nullable();
            $table->boolean('is_change_daara')->nullable();
            $table->boolean('is_change_dieuw')->nullable();

            $table->dateTime('date_change_talibe')->nullable();
            $table->dateTime('date_change_hizib')->nullable();
            $table->dateTime('date_change_daara')->nullable();
            $table->dateTime('date_change_dieuw')->nullable();

            $table->integer('user_id_change_hizib')->nullable();
            $table->integer('user_id_change_daara')->nullable();
            $table->integer('user_id_change_dieuw')->nullable();

            $table->string('user_name_change_hizib')->nullable();
            $table->string('user_name_change_daara')->nullable();
            $table->string('user_name_change_dieuw')->nullable();

            $table->string('user_email_change_hizib')->nullable();
            $table->string('user_email_change_daara')->nullable();
            $table->string('user_email_change_dieuw')->nullable();

            $table->text('commentaire')->nullable();

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
        Schema::dropIfExists('history_talibes');
    }
}
