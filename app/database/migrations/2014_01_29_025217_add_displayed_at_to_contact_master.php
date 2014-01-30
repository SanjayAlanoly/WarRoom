<?php

use Illuminate\Database\Migrations\Migration;

class AddDisplayedAtToContactMaster extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
                Schema::table('contact_master', function($t) {
                    $t->boolean('displayed');
                    $t->date('displayed_at');
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contact_master', function($t) {
                    $t->dropColumn('displayed');
                    $t->dropColumn('displayed_at');
                });
	}

}