<?php
class UsersTableSeeder extends Seeder {
	public function run(){
		DB::table('users')->insert(
            array(
                    array(
                            'email'    => 'max@gmail.com',
                            'username' => 'max',
                            'password' => Hash::make('test')
                    ),
                    array(
                            'email'    => 'john@gmail.com',
                            'username' => 'john',
                            'password' => Hash::make('test')
                    ),
            ));
	}
}
