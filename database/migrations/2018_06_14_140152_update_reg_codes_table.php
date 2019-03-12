<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateRegCodesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('reg_codes', function (Blueprint $table) {
            
            if(!Schema::hasColumn('reg_codes', 'price')){
                $table->float('price')->nullable()->default(2.99)->comment('价格');
            }

            if(!Schema::hasColumn('reg_codes', 'name')){
            $table->string('name')->nullable()->comment('激活码别名');
            }

            $table->integer('template')->nullable()->default(0);

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
