<?php

use Illuminate\Database\Migrations\Migration;

class CreateCallBackTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('call_back', function($t){
                    $t->increments('id');
                    $t->integer('contact_id');
                    $t->date('call_date');
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
		Schema::drop('call_back');
	}

}