<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('訂單ID');
            $table->integer('product_id')->comment('產品ID')->nullable();
            $table->integer('card_id')->comment('卡牌ID')->nullable();
            $table->integer('number')->comment('數量')->nullable();
            $table->float('unit_price')->comment('單價')->nullable();
            $table->float('subtotal')->comment('小計')->nullable();
            $table->string('title')->comment('名稱')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
