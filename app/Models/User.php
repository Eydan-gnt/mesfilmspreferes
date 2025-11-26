<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $email
 * @property string|null $avatar
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Avi[] $avis
 * @property Collection|Favori[] $favoris
 * @property Collection|FriendUser[] $friend_users
 * @property Collection|Partage[] $partages
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'firstname',
		'lastname',
		'username',
		'email',
		'avatar',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function avis()
	{
		return $this->hasMany(Avi::class);
	}

	public function favoris()
	{
		return $this->hasMany(Favori::class);
	}

	public function friend_users()
	{
		return $this->hasMany(FriendUser::class);
	}

	public function partages()
	{
		return $this->hasMany(Partage::class);
	}
}
