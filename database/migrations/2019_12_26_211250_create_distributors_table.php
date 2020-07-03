<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
            $table->string('company', 100)->nullable();
            $table->string('director', 60)->nullable();
            $table->text('description')->nullable();
            $table->string('tax_code')->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('iban')->nullable();
            $table->string('logo',255)->nullable();
            $table->string('address',255)->nullable();
            $table->string('phone',60)->nullable();
            $table->string('website',255)->nullable();
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
        Schema::dropIfExists('distributors');
    }
}
