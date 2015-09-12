<?php

use Illuminate\Database\Migrations\Migration;

class ProjectsImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create cross table
        Schema::create('projects_images', function ($table) {
            $table->integer('project_id');
            $table->integer('image_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop table
        Schema::drop('projects_images');
    }
}
