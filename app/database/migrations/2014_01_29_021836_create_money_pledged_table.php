<?php

use Illuminate\Database\Migrations\Migration;

class CreateMoneyPledgedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pledged', function($t){
                    $t->increments('id');
                    $t->integer('contact_id');
                    $t->integer('amount_pledged');
                    $t->integer('amount_collected');
                    $t->date('collect_date');
                    $t->text('comments');
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
		Schema::drop('pledged');
	}

}