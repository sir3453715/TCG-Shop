<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名稱');
            $table->string('email')->unique()->comment('帳號');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('密碼');
            $table->boolean('status')->comment('狀態 [true:啟用|false:不啟用]')->nullable();
            $table->string('phone')->comment('電話')->nullable();
            $table->string('address')->comment('電話')->nullable();
            $table->string('google')->comment('Google帳號')->nullable();
            $table->string('facebook')->comment('Facebook帳號')->nullable();
            $table->string('line')->comment('Line帳號')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
