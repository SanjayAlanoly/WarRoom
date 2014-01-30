<?php
class ContactMasterSeeder extends Seeder {
	public function run() {
		// !!! All existing users are deleted !!!
		DB::table ( 'contact_master' )->delete ();
		
		ContactMaster::create ( array (
				
				'name' => 'John Doe',
				'phone' => '555-12345',
				'email' => 'john@doe.com',
				'status' => 'open',
				'volunteer_id' => 943 
		) );
		
		ContactMaster::create ( array (
				
				'name' => 'Jane Dear',
				'phone' => '555-55445',
				'email' => 'Jane@gmail.com',
				'status' => 'open',
				'volunteer_id' => 943 
		) );
		
		ContactMaster::create ( array (
				
				'name' => 'Sarah Parker',
				'phone' => '555-55412',
				'email' => 'sarah@hotmail.com',
				'status' => 'open',
				'volunteer_id' => 943 
		) );
		
		ContactMaster::create ( array (
				
				'name' => 'John Rambo',
				'phone' => '555-534425',
				'email' => 'ramboxxl@hollywood.com',
				'status' => 'open',
				'volunteer_id' => 943 
		)
		 );
		
		ContactMaster::create(array(
		
		'name'  => 'Howard White',
		'phone' => '555-55445',
		'email'     => 'howard@ineedmeth.com',
		'status' => 'open',
		'volunteer_id' => 943
		
		));
		
		
	}
}