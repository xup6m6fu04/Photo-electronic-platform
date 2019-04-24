<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('email')->unique(); // 信箱 (作為帳號使用)
            $table->string('password'); // 密碼
            $table->string('code')->nullable(); // 預留欄位
            $table->string('verify')->default('N'); // 信箱是否驗證
            $table->timestamp('verify_date')->nullable(); // 信箱驗證日期
            $table->string('gold')->default('N'); // 是否為黃金會員
            $table->timestamp('gold_date')->nullable(); // 成為黃金會員日期
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
