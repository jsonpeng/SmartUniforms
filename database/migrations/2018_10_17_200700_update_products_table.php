<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class UpdateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {

            if(!Schema::hasColumn('products', 'type')){
        
                $table->string('type')->nullable()->default('商品')->comment('类型 商品/校服');

            }
            

            if(!Schema::hasColumn('products', 'school_name')){
        
                $table->string('school_name')->nullable()->comment('学校名称');

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
