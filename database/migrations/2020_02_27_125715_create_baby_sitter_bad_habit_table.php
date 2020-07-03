<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBabySitterBadHabitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baby_sitter_bad_habit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('baby_sitter_id');
            $table->foreign('baby_sitter_id')
                ->references('id')
                ->on('baby_sitters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('bad_habit_id');
            $table->foreign('bad_habit_id')
                ->references('id')
                ->on('bad_habits')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('baby_sitter_bad_habit');
    }
}
