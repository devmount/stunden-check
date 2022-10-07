<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'category_id',
		'completed_at',
		'hours',
		'description',
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
	 * Get the user that created/worked this position.
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Get the category of this positions.
	 */
	public function category()
	{
		return $this->belongsTo('App\Models\Category');
	}
}
