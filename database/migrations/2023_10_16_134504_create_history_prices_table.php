<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id')->comment('卡牌ID')->nullable();
            $table->integer('price')->comment('歷史金額')->nullable();
            $table->dateTime('dateTime')->comment('日期')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('history_prices');
    }
}
