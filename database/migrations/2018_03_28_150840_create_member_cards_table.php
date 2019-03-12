<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMemberCardsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('register_type', ['微信', '手机'])->comment('激活方式');
            $table->string('code')->comment('激活码');
            $table->string('openid')->nullable()->comment('微信OPENID');
            $table->string('mobile')->nullable()->comment('手机号码');
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
        Schema::drop('member_cards');
    }
}
