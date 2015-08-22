<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create  table categories
        Schema::create("categories", function($table){
                $table->increments("id");
                $table->string("name");
                $table->string("slug");
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop table categories
        Schema::drop("categories");
    }
}
