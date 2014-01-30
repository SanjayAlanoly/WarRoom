<?php

use Illuminate\Database\Migrations\Migration;

class CreateContactMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_master', function($t){
			$t->increments('id');
			$t->string('name');
			$t->string('phone');
			$t->string('email');
			$t->enum('status',array('open', 'pledged', 'not_interested','call_back', 'collected','retracted'));
			$t->enum('donation_range',array('0-500','501-1000','1001-5000','5001-20000','20001-above'));
			$t->integer('volunteer_id');
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contact_master');
	}

}

