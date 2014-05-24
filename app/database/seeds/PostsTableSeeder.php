<?php
	class PostsTableSeeder extends Seeder {
		public function run(){
			DB::table('posts')->insert(array(
											array('id'=>1, 'user_id'=>2, 'privacy_id'=>1,
												  'content'=>"First post ever",
												  'category_id'=>1,
												  'tags'=>"Flamengo,Campeonato Carioca",
												  'version'=>1,
												  'anonymous'=>false),
											array('id'=>2, 'user_id'=>2, 'privacy_id'=>1,
												  'content'=>"Second post ever",
												  'category_id'=>1,
												  'tags'=>"Botafogo,Rio de Janeiro",
												  'version'=>1,
												  'anonymous'=>false),
									   ));
		}
}
