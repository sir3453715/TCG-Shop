<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();
            $table->integer('vendor_id')->comment('店家ID')->nullable();
            $table->integer('card_id')->comment('卡牌ID')->nullable();
            $table->boolean('status')->comment('狀態 [true:上架|false:下架]')->nullable();
            $table->string('price')->comment('原價金額')->nullable();
            $table->string('stock')->comment('庫存')->nullable();
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
        Schema::dropIfExists('products');
    }
}
