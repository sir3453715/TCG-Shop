<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingColumnToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('shipping')->comment('運費')->nullable();
            $table->string('shipping_code')->comment('物流編號')->nullable();
            $table->string('CVS_code')->comment('超商店號')->nullable();
            $table->string('CVS_name')->comment('超商門市名稱')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping');
            $table->dropColumn('shipping_code');
            $table->dropColumn('CVS_code');
            $table->dropColumn('CVS_name');
            //
        });
    }
}
