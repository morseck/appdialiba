<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationConfigurationsTable extends Migration
{
    public function up()
    {
        Schema::create('notification_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_type_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable(); // Si null = configuration globale
            $table->integer('daara_id')->unsigned()->nullable(); // Configuration par daara
            $table->json('channels'); // Canaux activés pour ce user/daara
            $table->json('recipients')->nullable(); // Users spécifiques
            $table->text('custom_message')->nullable(); // Message personnalisé
            $table->json('conditions')->nullable(); // Conditions spécifiques
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('notification_type_id')->references('id')->on('notification_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('daara_id')->references('id')->on('daaras');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_configurations');
    }
}
