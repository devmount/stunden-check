<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Parameter;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class Account extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'active',
		'start',
		'target_hours',
		'separate_accounting',
		'archived_at',
	];

	/**
	 * get all users assigned to this account
	 */
	public function users()
	{
		return $this->hasMany('App\Models\User','account_id','id');
	}

	/**
	 * Scope a query to only include active accounts.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive($query)
	{
		return $query->where('active', 1);
	}

	/**
	 * Scope a query to only include archived accounts.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeArchived($query)
	{
		return $query->where('active', 0);
	}

	/**
	 * get total number of hours of all positions of all users
	 */
	public function getSumHoursAttribute()
	{
		$hours = 0;
		foreach ($this->users as $u) {
			$hours += $u->sum_hours;
		}
		return $hours;
	}

	/**
	 * get total number of days of all excemptions of all users
	 */
	public function getExcemptionDaysAttribute()
	{
		$days = 0;
		foreach ($this->users as $u) {
			$days += $u->excemption_days;
		}
		return $days;
	}

	/**
	 * get total target number of hours
	 */
	public function getTotalHoursAttribute()
	{
		// TODO
		$hours = $this->users[0]->total_hours;
		if ($this->separate_accounting) {
			$hours += $this->users[1]->total_hours;
		}
		return $hours;
	}

	/**
	 * get hours still to work to reach quota until end of current cycle
	 */
	public function getMissingHoursAttribute()
	{
		return $this->total_hours - $this->sum_hours;
	}

	/**
	 * get sum of hours in current cycle
	 */
	public function getSumHoursCycleAttribute()
	{
		$hours = 0;
		foreach ($this->users as $u) {
			$hours += $u->sum_hours_cycle;
		}
		return $hours;
	}

	/**
	 * get total number of days of all excemptions of all users
	 */
	public function getExcemptionDaysCycleAttribute()
	{
		$days = 0;
		foreach ($this->users as $u) {
			$days += $u->excemption_days_cycle;
		}
		return $days;
	}

	/**
	 * get total target number of hours for current cycle
	 */
	public function getTotalHoursCycleAttribute()
	{
		$hours = 0;
		if ($this->separate_accounting) {
			foreach ($this->users as $u) {
				$hours += $u->total_hours_cycle;
			}
		} else {
			$days = Parameter::cycleDays($this->start) - $this->excemption_days_cycle;
			$hours = $this->target_hours * $days/Parameter::cycleDays();
		}
		return $hours;
	}

	/**
	 * get hours still to work to reach quota until end of current cycle
	 */
	public function getMissingHoursCycleAttribute()
	{
		return $this->total_hours_cycle - $this->sum_hours_cycle;
	}

	/**
	 * get status color depending on number of hours worked
	 */
	public function getStatusAttribute()
	{
		if ($this->sum_hours_cycle < $this->total_hours_cycle/2) return 0;
		if ($this->sum_hours_cycle < $this->total_hours_cycle) return 1;
		if ($this->sum_hours_cycle >= $this->total_hours_cycle) return 2;
	}

	/**
	 * get sum of hours in given cycle
	 */
	public function sumHoursByCycle($cycleStart)
	{
		$hours = 0;
		foreach ($this->users as $u) {
			$hours += $u->sumHoursByCycle($cycleStart);
		}
		return $hours;
	}

	/**
	 * get total number of days of all excemptions of all users in given cycle
	 */
	public function excemptionDaysByCycle($cycleStart)
	{
		$days = 0;
		foreach ($this->users as $u) {
			$days += $u->excemptionDaysByCycle($cycleStart);
		}
		return $days;
	}

	/**
	 * get total target number of hours for given cycle
	 */
	public function totalHoursByCycle($cycleStart)
	{
		$start = max($this->start, $cycleStart);
		$hours = 0;
		if ($this->separate_accounting) {
			foreach ($this->users as $u) {
				$hours += $u->totalHoursByCycle($start);
			}
		} else {
			$cycleDays = Carbon::create($start)->diffInDays(Carbon::create($cycleStart)->addYear()->subDay());
			$days = $cycleDays - $this->excemptionDaysByCycle($start);
			$hours = $this->target_hours * $days/Parameter::cycleDays(); // TODO: handle given cycle days
		}
		return $hours;
	}

	/**
	 * get hours still to work to reach quota until end of given cycle
	 */
	public function missingHoursByCycle($cycleStart)
	{
		return $this->totalHoursByCycle($cycleStart) - $this->sumHoursByCycle($cycleStart);
	}

	/**
	 * get status color depending on number of hours worked in given cycle
	 */
	public function statusByCycle($cycleStart)
	{
		if ($this->sumHoursByCycle($cycleStart) < $this->totalHoursByCycle($cycleStart)/2) return 0;
		if ($this->sumHoursByCycle($cycleStart) < $this->totalHoursByCycle($cycleStart)) return 1;
		if ($this->sumHoursByCycle($cycleStart) >= $this->totalHoursByCycle($cycleStart)) return 2;
	}
}
