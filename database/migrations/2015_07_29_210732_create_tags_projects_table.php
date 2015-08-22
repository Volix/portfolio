<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create cross table projects with tags
        Schema::create("projects_tags", function ($table){
                $table->integer("project_id");
                $table->integer("tag_id");
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop cross table projects with tags
        Schema::drop("projects_tags");
    }
}
