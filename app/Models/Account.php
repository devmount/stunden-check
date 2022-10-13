<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
		'archcived_at',
	];

	/**
	 * get all users assigned to this account
	 */
	public function users()
	{
		return $this->hasMany('App\Models\User','account_id','id');
	}

	/**
	 * get all excemptions assigned to this account
	 */
	public function excemptions()
	{
		return $this->hasMany('App\Models\Excemption','account_id','id');
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
	 * get total target number of hours
	 */
	public function getTotalHoursAttribute()
	{
		$hours = $this->users[0]->total_hours;
		if ($this->sesparate_accounting) {
			$hours += $this->users[1]->total_hours;
		}
		return $hours;
	}

	/**
	 * get hours still to work to reach quota until end of current cycle
	 */
	public function getMissingHoursAttribute()
	{
		$hours = 0;
		foreach ($this->users as $u) {
			$hours += $u->missing_hours;
		}
		return $hours;
	}

	/**
	 * get sum of hours in current cycle
	 */
	public function getCycleHoursAttribute()
	{
		$hours = 0;
		foreach ($this->users as $u) {
			$hours += $u->cycle_hours;
		}
		return $hours;
	}

	/**
	 * get status color depending on number of hours worked
	 */
	public function getStatusAttribute()
	{
		// TODO
		if ($this->total_hours - $this->missing_hours < $this->total_hours/2) return 0;
		if ($this->sum_hours < $this->total_hours) return 1;
		if ($this->sum_hours >= $this->total_hours) return 2;
	}
}
