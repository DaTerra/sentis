<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// privacies domain table
		Schema::create('privacies', function($table){
			$table->increments('id');
			$table->string('name');
		});

		// feelings domain table
		Schema::create('feelings', function($table){
			$table->increments('id');
			$table->string('name');
			$table->binary('icon');
		});
		
		// categories domain table
		Schema::create('categories', function($table){
			$table->increments('id');
			$table->string('name');
		});
		
		// users table
		Schema::create('users', function($table){
			$table->increments('id');
			$table->string('username');
			$table->string('password');
			$table->boolean('is_admin');
			$table->timestamps();
		});
		
		// posts table
		Schema::create('posts', function($table){
			$table->increments('id');
			$table->integer('user_id')->references('id')->on('users');			
			$table->integer('privacy_id')->references('id')->on('privacies');
			$table->string('content');
			$table->integer('category')->references('id')->on('categories');
			$table->string('tags');
			$table->integer('version');
			$table->boolean('anonymous');
			$table->timestamps();
		});

		// sentis table 	
		Schema::create('sentis', function($table){
			$table->increments('id');
			$table->integer('user_id')->references('id')->on('users');
			$table->integer('post_id')->references('id')->on('posts');
			$table->string('geolocation');
			$table->timestamps();
		});

		// sentis table 	
		Schema::create('sentimeters', function($table){
			$table->increments('id');
			$table->integer('sentis_id')->references('id')->on('sentis');
			$table->integer('feeling_id')->references('id')->on('feelings');
			$table->integer('value');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		//TODO EH VALIDO FAZER?
		// Schema::table('cats', function($table){
		// 	$table->dropForeign('cats_user_id_foreign');
		// 	$table->dropColumn('user_id');
		// });
		
	}

}
