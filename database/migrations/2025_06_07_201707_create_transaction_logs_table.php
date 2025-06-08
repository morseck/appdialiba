<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model_type'); // Nom du modèle (ex: App\Talibe)
            $table->unsignedInteger('model_id')->nullable(); // ID de l'enregistrement
            $table->string('action'); // create, update, delete
            $table->unsignedInteger('user_id')->nullable(); // ID de l'utilisateur qui a fait l'action
            $table->string('user_name')->nullable(); // Nom de l'utilisateur
            $table->string('user_email')->nullable(); // Email de l'utilisateur
            $table->json('old_values')->nullable(); // Anciennes valeurs (pour update et delete)
            $table->json('new_values')->nullable(); // Nouvelles valeurs (pour create et update)
            $table->json('changes')->nullable(); // Seulement les champs modifiés
            $table->string('ip_address')->nullable(); // Adresse IP
            $table->string('user_agent')->nullable(); // User agent
            $table->text('description')->nullable(); // Description personnalisée
            $table->text('context')->nullable(); // Contexte supplémentaire
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_logs');
    }
}
