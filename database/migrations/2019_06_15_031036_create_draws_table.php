<?php

use App\Enums\PrizeTypes;
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
            $table->unsignedBigInteger('number')->unique();
            $table->unsignedBigInteger('user_id')->unique();
            $table->enum('type', PrizeTypes::toArray());
            $table->timestamps();
        });
    }
}
