<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCardRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_records', function (Blueprint $table) {
            $table->increments('id');

            $table->string('card_id')->comment('读卡器id');
            $table->string('content')->nullable()->comment('读取到的信息');
            $table->timestamp('read_time')->nullable()->comment('读取时间');
            $table->string('remark')->nullable()->comment('别名');
            $table->string('location')->nullable()->comment('位置信息');
            
            $table->index(['id', 'created_at']);
            $table->index('read_time');
            
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
        Schema::drop('card_records');
    }
}
