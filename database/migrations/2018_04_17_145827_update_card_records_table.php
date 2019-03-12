<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateCardRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_records', function (Blueprint $table) {
            
            if(!Schema::hasColumn('card_records', 'remark')){
                $table->string('remark')->nullable()->comment('别名');
            }

            if(!Schema::hasColumn('card_records', 'location')){
                $table->string('location')->nullable()->comment('位置信息');
            }

            $table->longtext('content')->nullable()->change();

            if(!Schema::hasColumn('card_records', 'code')){
                $table->integer('code')->nullable()->default(0)->comment('0未发 1发送了');
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
