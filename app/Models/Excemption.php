<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excemption extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'start',
		'end',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'user_id',
	];

	/**
	 * Get the user that owns the excemption.
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}
