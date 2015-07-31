<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProjectsDistinctiveImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create cross table projects with distinctive image
        Shema::create("project_distinctive_images", function($table){
                $table->integer("project_id")->unique();
                $table->integer("image_id")->unique();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop cross table projects with distinctive image
        Shema::drop("project_distinctive_images");
    }
}
