<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProprieteTypeHabitatatValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propriete_type_habitatat_values', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->unsignedBigInteger('propriete_type_habitat');
            $table->unsignedBigInteger('habitat');

            $table->foreign('propriete_type_habitat')
                  ->references('id')
                  ->on('propriete_type_habitats')
                  ->onDelete('cascade');

            $table->foreign('habitat')
                  ->references('id')
                  ->on('habitats')
                  ->onDelete('cascade');

            $table->unique(['propriete_type_habitat','habitat'],'prorpieteTypeHabitatValue');
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
        Schema::dropIfExists('propriete_type_habitatat_values');
    }
}
