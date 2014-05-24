<?php
	class DomainTablesSeeder extends Seeder {
		public function run(){
			DB::table('privacies')->insert(array(
											array('id'=>1, 'name'=>"Public"),
											array('id'=>2, 'name'=>"Protected"),
											array('id'=>3, 'name'=>"Private"),
										));

			DB::table('categories')->insert(array(
											array('id'=>1, 'name'=>"Sports"),
											array('id'=>2, 'name'=>"Politics"),
											array('id'=>3, 'name'=>"Women"),
										));

		}
}
