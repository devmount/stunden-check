<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \DateTime;

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
		return self::where('key', '=', $key)->first()?->value;
	}

	/**
	 * Get start_accounting parameter.
	 *
	 * @return DateTime
	 */
	public static function startAccounting()
	{
		$start = new DateTime(self::key('start_accounting'));
		return date_date_set($start, date("Y"), $start->format('m'), $start->format('d'));
	}
}
