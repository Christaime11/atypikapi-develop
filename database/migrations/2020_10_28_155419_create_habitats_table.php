<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitats',
            function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('description');
                $table->unsignedInteger('nombreChambre');
                $table->unsignedFloat('prixParNuit');
                $table->unsignedInteger('nombreLit');
                $table->string('adresse');
                $table->boolean('hasTelevision')->default(0);
                $table->boolean('hasClimatiseur')->default(0);
                $table->boolean('hasChauffage')->default(0);
                $table->boolean('hasInternet')->default(0);
                $table->boolean('valideParAtypik')->default(0); // habitat validé ou non par atypikhouse
                $table->unsignedBigInteger("proprietaire");
                $table->unsignedBigInteger('typeHabitat');

                $table->foreign("proprietaire")
                      ->references("id")
                      ->on("users");

                $table->foreign('typeHabitat')
                      ->references('id')
                      ->on('type_habitats');

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
        Schema::dropIfExists('habitats');
    }
}
