<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableSubfolders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create table subfolders for projects;
        Schema::create("categories_subfolders", function ($table) {
            $table->integer("category_id");
            $table->string("folder_name");
            $table->string("folder_slug");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop table subfolders for projects;
        Schema::drop("categories_subfolders");
    }
}
