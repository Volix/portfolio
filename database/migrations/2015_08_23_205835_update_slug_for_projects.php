<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlugForProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add column slug to projects
		Schema::table("projects", function($table) {
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
        //Delete column slug
		Schema::table("projects", function($table)  {
			$table->dropColumn('slug');
		});
    }
}
