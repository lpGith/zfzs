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
            $table->bigIncrements('id');
            $table->string('username', 50)->comment('用户名');
            $table->string('password', 255)->comment('密码');
            $table->string('phone', 15)->nullable()->comment('电话号码');
            $table->string('email', 30)->nullable()->comment('邮箱');
            $table->char('last_ip', 15)->default('')->comment('最后登录ip');
            $table->enum('gender', ['male', 'female'])->default('male')->comment('性别');
            $table->timestamps();
            $table->softDeletes();
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
