<?php
class UsersTableSeeder extends Seeder {
	public function run(){
		DB::table('users')->insert(
            array(
                    array(
                            'username' => 'max',
                            'password' => Hash::make('test'),
                            'is_admin'  => true
                    ),
                    array(
                            'username' => 'john',
                            'password' => Hash::make('test'),
                            'is_admin'  => false
                    ),
            ));
	}
}
