<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payements', function (Blueprint $table) {
            $table->id();
            $table->unsignedFloat('montant');
            /**
             * Pour chaque payement, des factures
             * seront générées au format pdf
             * et stocker sur le serveurs.
             * le liens de ces fichiers pdf sont
             * stocker dans le champ facture
             */
            $table->string('lienFacture');
            $table->unsignedBigInteger('reservation');

            $table->foreign('reservation')
                  ->references('id')
                  ->on('reservations');

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
        Schema::dropIfExists('payements');
    }
}
