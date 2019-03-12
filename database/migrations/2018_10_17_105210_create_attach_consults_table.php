<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttachConsultsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attach_consults', function (Blueprint $table) {
            $table->increments('id');
         
            $table->string('pname')->comment('品名');
            $table->string('chima')->comment('尺码');
            $table->integer('zengding')->nullable()->default(0)->comment('征订数量');
            $table->integer('tuihui')->nullable()->default(0)->comment('退回数量');

       
            $table->integer('consult_id')->unsigned();
            $table->foreign('consult_id')->references('id')->on('consult_records');

            $table->index(['id', 'created_at']);
            $table->index('consult_id');

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
        Schema::drop('attach_consults');
    }
}
