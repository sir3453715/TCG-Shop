<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('標題')->nullable();
            $table->string('image')->comment('卡牌圖片')->nullable();
            $table->string('link')->comment('連結')->nullable();
            $table->string('sort')->comment('排序')->nullable();
            $table->boolean('status')->comment('狀態 [true:啟用|false:不啟用]')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
