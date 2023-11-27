<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->comment('卡牌語系')->nullable();
            $table->integer('tw_id')->comment('台版卡編號(主編號)')->nullable();
            $table->string('name')->comment('卡牌名稱')->nullable();
            $table->string('hp')->comment('卡牌血量(生命)')->nullable();
            $table->string('image')->comment('卡牌圖片')->nullable();
            $table->string('series')->comment('系列名稱')->nullable();
            $table->string('serial_number')->comment('系列編號')->nullable();
            $table->string('attribute')->comment('屬性')->nullable();
            $table->string('type')->comment('卡牌類型')->nullable();
            $table->text('skill')->comment('技能')->nullable();
            $table->string('weakpoint')->comment('弱點')->nullable();
            $table->string('weakpoint_value')->comment('弱點數值')->nullable();
            $table->string('resist')->comment('抵抗力')->nullable();
            $table->string('resist_value')->comment('抵抗力數值')->nullable();
            $table->string('escape')->comment('撤退')->nullable();
            $table->string('rarity')->comment('稀有度')->nullable();
            $table->string('competition_number')->comment('賽制編號')->nullable();
            $table->string('default_price')->comment('預設金額')->nullable();
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
        Schema::dropIfExists('cards');
    }
}
