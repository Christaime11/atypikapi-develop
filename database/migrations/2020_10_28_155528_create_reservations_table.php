<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('locataire');
            $table->unsignedBigInteger('habitat_id');
            $table->json('detail_habitat');//les informations de l'habitat peuvent être modifiée dont on sauvagarde les informations actuelle
            $table->unsignedInteger('nbrOccupant');
            $table->unsignedFloat('montantTotal');
            $table->boolean('payementEffectue')->default(0);// payé => 1, pas payé =>0
            $table->string('lienfacture')->nullable();
            $table->date('dateArrivee');
            $table->date('dateDepart');

            $table->foreign('locataire')
                  ->references('id')
                  ->on('users');

            $table->foreign('habitat_id')
                    ->references('id')
                    ->on('habitats');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
