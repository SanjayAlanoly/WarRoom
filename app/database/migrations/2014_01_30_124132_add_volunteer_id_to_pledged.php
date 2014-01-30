<?php

use Illuminate\Database\Migrations\Migration;

class AddVolunteerIdToPledged extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pledged', function($t){
                    $t->integer('volunteer_id');
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pledged', function($t){
                    $t->dropColumn('volunteer_id');
                });
	}

}