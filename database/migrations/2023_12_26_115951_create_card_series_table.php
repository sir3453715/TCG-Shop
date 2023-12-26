<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_series', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('系列名稱')->nullable();
            $table->string('serial_number')->comment('系列編號')->nullable();
            $table->integer('sort')->comment('排序')->nullable();
            $table->string('kingdom')->comment('卡牌領域[如:寶可夢|海賊王]')->nullable();
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
        Schema::dropIfExists('card_series');
    }
}
