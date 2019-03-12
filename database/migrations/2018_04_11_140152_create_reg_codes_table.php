<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegCodesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('reg_codes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('code')->nullable()->unique()->comment('激活码');
            $table->integer('status')->nullable()->default(0)->comment('使用状态0未使用1已使用');
            $table->string('share_link')->nullable()->comment('分享链接');

          
            $table->float('price')->nullable()->default(2.99)->comment('价格');
            $table->integer('item_id')->nullable()->comment('关联商品id');
            $table->integer('user_id')->nullable()->comment('关联用户id');

            $table->index(['id', 'created_at']);
            $table->index('item_id');
            $table->index('user_id');

            $table->timestamps();
            $table->softDeletes();
        });

        /*
        Schema::create('reg_codes_rel', function (Blueprint $table) {
            $table->increments('id');

   
            $table->integer('code_id')->unsigned();
            $table->foreign('code_id')->references('id')->on('reg_codes');
       
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
        */


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reg_codes');
    }
}
