<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTypesTable extends Migration
{
    public function up()
    {
        Schema::create('notification_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // ex: 'nouveau_talibe', 'changement_daara'
            $table->string('display_name'); // Nom affiché
            $table->text('description')->nullable();
            $table->text('message_template'); // Template du message avec variables
            $table->string('event_trigger'); // Event qui déclenche la notification
            $table->json('channels'); // ['mail', 'sms', 'database']
            $table->json('default_recipients')->nullable(); // Rôles par défaut
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_types');
    }
}
