<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draws');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('number_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
            $table->foreign('number_id')
                  ->references('id')
                  ->on('numbers');
            $table->unique('user_id', 'number_id');
            $table->timestamps();
        });
    }
}
