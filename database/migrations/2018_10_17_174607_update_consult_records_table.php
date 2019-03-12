<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateConsultRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('consult_records', function (Blueprint $table) {

          if(!Schema::hasColumn('consult_records', 'sex')){

                $table->string('sex')->comment('性别 男/女');

          }


          if(!Schema::hasColumn('consult_records', 'school_name')){

                $table->string('school_name')->comment('学校名称');

          }

          if(!Schema::hasColumn('consult_records', 'type')){

                $table->string('type')->nullable()->default('调换单')->comment('类型 征订单/调换单');

          }

          if(!Schema::hasColumn('consult_records', 'commit')){

                $table->string('commit')->nullable()->comment('家长联系电话');

          }

          if(!Schema::hasColumn('consult_records', 'do')){

              $table->integer('do')->nullable()->default(0)->comment('处理');

           }


          if(!Schema::hasColumn('consult_records', 'user_edit')){

              $table->integer('user_edit')->nullable()->default(0)->comment('用户修改次数');

          }



          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
