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
        Shema::create("projects_tags", functions($table){
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
        Shema::drop("projects_tags");
    }
}
