<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->json('category_ids')->nullable();
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->text('short_description');
            $table->text('long_description');
            $table->string('alias')->unique();
            $table->integer('price');
            $table->integer('old_price')->nullable();
            $table->string('main_image');
            $table->boolean('top_status')->default(1);
            $table->boolean('hot_status')->default(1);
            $table->boolean('new_status')->default(1);
            $table->boolean('status')->default(1);
            $table->integer('bulk_quantity')->nullable();
            $table->integer('bulk_percent')->nullable();
            $table->boolean('offerable')->default(0);
            $table->string('type');
            $table->string('text');
            $table->string('gender');
            $table->boolean('watermark')->default(0);
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
        Schema::dropIfExists('product_models');
    }
}
