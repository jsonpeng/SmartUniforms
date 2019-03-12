<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateAttachConsultsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attach_consults', function (Blueprint $table) {
            if(!Schema::hasColumn('attach_consults', 'price')){
                $table->float('price')->comment('价格');
            }

            if(!Schema::hasColumn('attach_consults', 'do')){
                 $table->integer('do')->nullable()->default(0)->comment('处理');
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
