<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create table projects
         Schema::create('projects', function ($table) {
           $table->increments('id');
           $table->string('name');
           $table->string('short_description');
           $table->text('description');
           $table->string('project_url');
           $table->date('made_at');
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
        //Drop table projects
        Schema::drop('projects');
    }
}
