<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_comment', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('記錄人員ID')->nullable();
            $table->integer('order_id')->comment('訂單ID')->nullable();
            $table->dateTime('dateTime')->comment('紀錄時間')->nullable();
            $table->text('content')->comment('備註內容')->nullable();
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
        Schema::dropIfExists('order_comment');
    }
}
