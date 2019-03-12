<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsultRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consult_records', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable()->comment('姓名');
            $table->string('class')->nullable()->comment('班级');
            $table->string('shengao')->nullable()->comment('身高');
            $table->string('tizhong')->nullable()->comment('体重');
            
            $table->integer('chima')->nullable()->comment('尺码');
            $table->string('guige')->nullable()->comment('规格');

            $table->string('remark')->nullable()->comment('备注');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('consult_records');
    }
}
