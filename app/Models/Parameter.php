<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\InputType;

class Parameter extends Model
{
	use HasFactory;

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'key',
		'value',
	];

	/**
	 * Get parameter by key.
	 *
	 * @param  String  $key
	 * @return String
	 */
	public static function key(String $key)
	{
		return self::where('key', '=', $key)->first()->value;
	}
}
