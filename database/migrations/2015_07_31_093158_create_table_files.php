<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create table files
        Shema::create("files", function ($table){
            $table->increments("id");
            $table->string("extension");
            $table->float("size");
            $table->string("name");
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop table files
        Shema::drop("files");
    }
}
