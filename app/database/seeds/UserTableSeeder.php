<?php
class UserTableSeeder extends Seeder {

    public function run()
    {
        // !!! All existing users are deleted !!!
        DB::table('user')->delete();

        User::create(array(
            
            'name'  => 'Administrator',
            'phone' => '1234567890',
            'password'  => Hash::make('pass'),
            'email'     => 'admin@localhost'
        ));
    }
}