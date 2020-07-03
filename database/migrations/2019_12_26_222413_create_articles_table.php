<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('article_category_id');
            $table->foreign('article_category_id')
                ->references('id')
                ->on('article_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title');
            $table->longText('description');
            $table->string('main_image');
            $table->string('alias')->unique();
            $table->integer('view')->default(0);
            $table->integer('rating')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE articles ADD FULLTEXT articles_index (title,description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
        Schema::table('articles', function($table) {
            $table->dropIndex('articles_index');
        });
    }
}
