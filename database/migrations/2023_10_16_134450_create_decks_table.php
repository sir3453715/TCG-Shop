<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('會員ID')->nullable();
            $table->string('title')->comment('牌組名稱')->nullable();
            $table->boolean('is_recommend')->comment('推薦牌組[true:是|false:不是]')->nullable();
            $table->string('competition')->comment('賽制')->nullable();
            $table->text('card_info')->comment('牌組內容')->nullable();
            $table->text('code')->comment('牌組代碼')->nullable();
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
        Schema::dropIfExists('decks');
    }
}
