<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->uuid('uuid')->nullable()->index()->after('id');
			$table->string('name')->nullable()->change();
			$table->string('last_name')->nullable()->after('name');
			$table->string('phone')->nullable();
			$table->dateTime('disabled_at')->nullable();
			$table->integer('disabled_by_user_id')->nullable()->references('id')->on('users');

			$table->dateTime('email_confirmation_sent_at')->nullable();
			$table->dateTime('email_confirmed_at')->nullable();
			$table->string('confirmation_code')->nullable();

			$table->text('avatar_url')->nullable();
			$table->text('avatar_path')->nullable();
			$table->string('avatar_disk')->nullable();

			$table->softDeletes();
			$table->integer('deleted_by_user_id')->nullable()->references('id')->on('users');

            $table->string('timezone')->nullable()->default('Australia/Melbourne');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('users', function(Blueprint $table) {
			$table->dropColumn([
				'uuid',
				'last_name',
				'disabled_at',
				'disabled_by_user_id',
				'email_confirmation_sent_at',
				'email_confirmed_at',
				'confirmation_code',
				'avatar_url',
				'avatar_path',
				'avatar_disk',
				'deleted_at',
				'deleted_by_user_id',
                'timezone'
			]);
		});
	}
}
