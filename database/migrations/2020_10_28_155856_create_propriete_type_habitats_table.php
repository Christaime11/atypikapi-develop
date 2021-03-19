<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProprieteTypeHabitatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propriete_type_habitats', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->longText('description');
            $table->unsignedBigInteger('typeHabitat');
            $table->foreign('typeHabitat')
                  ->references('id')
                  ->on('type_habitats')
                  ->onDelete('cascade');
            $table->unique(['libelle','typeHabitat'],'prorpieteTypeHabitat');
            $table->softDeletes();
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
        Schema::dropIfExists('propriete_type_habitats');
    }
}
