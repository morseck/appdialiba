<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationLogsTable extends Migration
{
    public function up()
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_type_id')->unsigned();
            $table->string('channel'); // mail, sms, database
            $table->integer('recipient_id')->unsigned(); // User destinataire
            $table->text('message');
            $table->string('status'); // sent, failed, pending
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable(); // Données additionnelles
            $table->timestamps();

            $table->foreign('notification_type_id')->references('id')->on('notification_types');
            $table->foreign('recipient_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_logs');
    }
}
