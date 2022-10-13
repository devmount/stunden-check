<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Parameter;
use \DateTime;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'firstname',
		'lastname',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'is_admin',
		'account_id',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * Get the user that owns the phone.
	 */
	public function account()
	{
		return $this->belongsTo('App\Models\Account');
	}

	/**
	 * get all positions completed by this user
	 */
	public function positions()
	{
		return $this->hasMany('App\Models\Position','user_id','id');
	}

	/**
	 * get number of hours to work for a single user
	 */
	public function getTargetHoursAttribute()
	{
		// half hours needed when separate accounting is active
		return $this->account->separate_accounting
			? $this->account->target_hours/2
			: $this->account->target_hours;
	}

	/**
	 * get total number of hours of all positions
	 */
	public function getSumHoursAttribute()
	{
		$hours = 0;
		foreach ($this->positions as $p) {
			$hours += $p->hours;
		}
		return $hours;
	}

	/**
	 * get total target number of hours
	 */
	public function getTotalHoursAttribute()
	{
		$cycle = Parameter::startAccounting();
		$end = $cycle >= now() ? $cycle : $cycle->modify('+1 year');
		$start = new DateTime($this->account->start);
		$diff = $start->diff($end);
		$years = $diff->y;
		// calculate fraction if account start differs from cycle start
		if ($diff->m > 0 or $diff->d > 0) {
			$years += $diff->days / (($years+1)*365);
		}
		// TODO reduce by excemptions
		return $this->target_hours * $years;
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
	public function getCycleHoursAttribute()
	{
		$cycle = Parameter::startAccounting();
		$start = $cycle < now() ? $cycle : $cycle->modify('-1 year');
		$hours = 0;
		foreach ($this->positions->where('completed_at', '>', $start->format('Y-m-d')) as $p) {
			$hours += $p->hours;
		}
		return $hours;
	}

	/**
	 * get status depending on number of hours worked
	 */
	public function getStatusAttribute()
	{
		if ($this->sum_hours < $this->total_hours/2) return 0;
		if ($this->sum_hours < $this->total_hours) return 1;
		if ($this->sum_hours >= $this->total_hours) return 2;
	}
}
