<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOwnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('own_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->json('category_ids');
            $table->string('title');
            $table->text('description');
            $table->integer('price');
            $table->string('phone');
            $table->string('manufacturer')->nullable();
            $table->string('color')->nullable();
            $table->string('condition');
            $table->string('alias');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE own_products ADD FULLTEXT own_products_index (title,description,manufacturer)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('own_products');
        Schema::table('own_products', function($table) {
            $table->dropIndex('own_products_index');
        });
    }
}
