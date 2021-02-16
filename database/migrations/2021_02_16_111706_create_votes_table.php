<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voter_id')->unsigned();
            $table->integer('candidate_id')->unsigned();
            $table->string('status')->default(0);
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('voter_id')
                ->references('id')->on('voters')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('candidate_id')
                ->references('id')->on('candidates')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
