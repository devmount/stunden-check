<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'title',
		'description',
	];

	/**
	 * get all users assigned to this account
	 */
	public function positions()
	{
		return $this->hasMany('App\Models\Position','category_id','id');
	}
}
