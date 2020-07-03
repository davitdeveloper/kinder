<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBabySitterCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baby_sitter_cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('baby_sitter_id');
            $table->foreign('baby_sitter_id')
                ->references('id')
                ->on('baby_sitters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')
                ->references('id')
                ->on('cities')
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
        Schema::dropIfExists('baby_sitter_cities');
    }
}
