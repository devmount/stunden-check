<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
	 * @return Carbon
	 */
	public static function startAccounting()
	{
		return Carbon::parse(self::key('start_accounting'))->year(Carbon::now()->year);
	}

	/**
	 * Calculate current cycle end.
	 *
	 * @return Carbon
	 */
	public static function cycleEnd()
	{
		$startAccounting = self::startAccounting();
		return Carbon::parse($startAccounting >= now()
			? $startAccounting
			: $startAccounting->addYear()->subDay());
	}

	/**
	 * Calculate current cycle start.
	 *
	 * @param  Carbon|null  $customStart
	 * @return Carbon
	 */
	public static function cycleStart($customStart = null)
	{
		$start = self::cycleEnd()->subYear()->addDay();
		return Carbon::parse($customStart && $customStart >= $start ? $customStart : $start);
	}

	/**
	 * Calculate number of days in current cycle.
	 *
	 * @param  Carbon|null  $customStart
	 * @return Carbon
	 */
	public static function cycleDays($customStart = null)
	{
		return Carbon::parse(self::cycleStart($customStart))->diffInDays(self::cycleEnd());
	}

	/**
	 * Calculate all cycles since beginning of accounting.
	 *
	 * @param Boolean|null  $reverse
	 * @param Carbon|string|null  $customStart
	 * @return Array
	 */
	public static function cycles($reverse = false, $customStart = null): Array
	{
		$period = CarbonPeriod::create(self::key('start_accounting'), '1 year', self::cycleEnd())->toArray();
		if ($customStart) {
			$start = Carbon::create($customStart);
			foreach ($period as $key => $date) {
				if ($start >= Carbon::create($date)->addYear()) {
					unset($period[$key]);
				}
			}
		}

		// Handle the case that the current date is in the same year, but still before the cycle start
		$lastEntry = last($period);
		if (Carbon::create($lastEntry) > Carbon::now()) {
			array_pop($period);
		}

		if ($reverse) {
			return array_reverse($period);
		} else {
			return $period;
		}
	}
}
