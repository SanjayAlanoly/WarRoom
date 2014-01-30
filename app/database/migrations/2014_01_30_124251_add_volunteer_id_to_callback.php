<?php

use Illuminate\Database\Migrations\Migration;

class AddVolunteerIdToCallback extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('call_back', function($t){
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
		Schema::table('volunteer_id', function($t){
                    $t->dropColumn('volunteer_id');
                });
	}

}