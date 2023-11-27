<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->comment('父訂單ID')->nullable();
            $table->integer('vendor_id')->comment('店家ID')->nullable();
            $table->string('seccode')->comment('訂單編號')->nullable();
            $table->integer('user_id')->comment('會員ID')->nullable();
            $table->integer('status')->comment('訂單狀態')->nullable();
            $table->integer('total')->comment('訂單金額')->nullable();
            $table->string('payment')->comment('付款方式')->nullable();
            $table->integer('pay_status')->comment('付款狀態')->nullable();
            $table->string('shipment')->comment('物流方式')->nullable();
            $table->string('buyer_name')->comment('購買人姓名')->nullable();
            $table->string('buyer_phone')->comment('購買人電話')->nullable();
            $table->string('buyer_address')->comment('購買人地址')->nullable();
            $table->string('note')->comment('訂單備註')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
