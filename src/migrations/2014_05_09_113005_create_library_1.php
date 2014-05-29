<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibrary1 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('library', function($table)
		{
		    $table->increments('id');
			$table->enum('type', array('jpg', 'zip'));
		    $table->integer('size');
		    $table->string('path');
		    $table->integer('user_id');
		    $table->softDeletes();
		    $table->timestamps();
		    $table->engine = 'InnoDB';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('libraries');
	}

}
