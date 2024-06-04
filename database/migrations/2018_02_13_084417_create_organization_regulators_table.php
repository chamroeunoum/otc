<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationRegulatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organization_regulators', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organization_id')->unsigned(); 
			$table->integer('regulator_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('organization_regulators');
	}

}