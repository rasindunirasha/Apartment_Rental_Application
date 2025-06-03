<?php

namespace App\Models;

use EMedia\Oxygen\Entities\Traits\OxygenUserTrait;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
	// use HasApiTokens;
	use HasFactory, Notifiable;
	use OxygenUserTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'name',
		'first_name',
		'last_name',
		'email',
		'password',
		'timezone',
		'phone',
		'confirmation_code',
		'avatar_path',
		'avatar_disk',
		'avatar_url',
		'email_confirmed_at',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'name',
		'password',
		'remember_token',
		'avatar_path',
		'avatar_disk'
	];

	/**
	 *
	 * The attributes that should be visible for arrays.
	 *
	 * @var string[]
	 */
	protected $visible  = [
		'uuid',
		'first_name',
		'last_name',
		'full_name',
		'email',
		'avatar_url',
		'timezone',
		'email_confirmed_at',
	];

	/**
	 *
	 * The attributes that should be automatically appended.
	 *
	 * @var string[]
	 */
	protected $appends  = [
		'first_name',
		'full_name'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id' => 'string',
		'email_confirmed_at' => 'datetime',
		'password' => 'hashed',
	];

	/**
	 *
	 * Columns which are searchable by default.
	 *
	 * @var string[]
	 */
	protected $searchable = [
		'name',
		'last_name',
		'email'
	];

	/**
	 *
	 * Fields that may be added to the API responses.
	 *
	 * @return string[]
	 */
	public function getExtraApiFields(): array
	{
		return [
			'access_token',
		];
	}

	public function sendEmailVerificationNotification(): void
	{
		$this->notify(new VerifyEmail);
	}

}
