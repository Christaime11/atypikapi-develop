<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->string('note');
            $table->string('contenu');
            $table->boolean('reported')->default(0);
            $table->json('detail_habitat');
            $table->unsignedBigInteger('auteur');
            $table->unsignedBigInteger('habitat');

            $table->foreign('auteur')
                  ->references('id')
                  ->on('users');

            $table->foreign('habitat')
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
        Schema::dropIfExists('commentaires');
    }
}
