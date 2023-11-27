<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('活動標題')->nullable();
            $table->string('image')->comment('活動圖片')->nullable();
            $table->integer('class_id')->comment('活動分類')->nullable();
            $table->text('content')->comment('活動內容')->nullable();
            $table->boolean('status')->comment('活動狀態')->nullable();
            $table->boolean('top')->comment('置頂')->nullable();
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
        Schema::dropIfExists('events');
    }
}
