<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMachineIdesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_ides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('machine_id')->nullable()->comment('机器ID');
            $table->string('machine_name')->nullable()->comment('机器名称');
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
        Schema::drop('machine_ides');
    }
}
