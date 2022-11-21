<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Parameter;
use \DateTime;

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
		$hours = $this->users[0]->total_hours_cycle;
		if ($this->separate_accounting) {
			$hours += $this->users[1]->total_hours_cycle;
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
		// TODO
		if ($this->sum_hours < $this->total_hours/2) return 0;
		if ($this->sum_hours < $this->total_hours) return 1;
		if ($this->sum_hours >= $this->total_hours) return 2;
	}
}
