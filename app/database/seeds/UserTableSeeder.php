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

        User::create(array(
            
            'name'  => 'Sanjay',
            'phone' => '1',
            'password'  => Hash::make('pass',10),
            'email'     => 'sanjay@localhost'
        ));

        User::create(array(
            
            'name'  => 'Aswin',
            'phone' => '2',
            'password'  => Hash::make('pass',8),
            'email'     => 'aswin@localhost'
        ));
    }
}