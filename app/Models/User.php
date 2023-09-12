<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Parameter;
use Carbon\Carbon;

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
		'is_admin',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
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
	 * get all excemptions assigned to this account
	 */
	public function excemptions()
	{
		return $this->hasMany('App\Models\Excemption','user_id','id');
	}

	/**
	 * gets the partner user if existing
	 */
	public function getPartnerAttribute()
	{
		// half hours needed when separate accounting is active
		$users = $this->account->users;
		return count($users) > 1 && !$this->account->separate_accounting
			? $users->first(fn ($u) => $u->id != $this->id)
			: null;
	}

	/**
	 * get number of hours to work for a single user in one cycle
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
	 * get total number of days of all excemptions
	 */
	public function getExcemptionDaysAttribute()
	{
		$days = 0;
		foreach ($this->excemptions as $e) {
			$start = Carbon::parse($e->start);
			$end = Carbon::parse($e->end);
			$diff = $start->diffInDays($end, false);
			if ($diff < 0) continue;
			$days += $diff > 0 ? $diff : 1;
		}
		return $days;
	}

	/**
	 * get total target number of hours
	 */
	public function getTotalHoursAttribute()
	{
		$cycle = Parameter::startAccounting();
		$end = $cycle >= now() ? $cycle : $cycle->addYear();
		$start = Carbon::parse($this->account->start);
		$days = $start->diffInDays($end, false) - $this->excemption_days;
		return $this->target_hours * $days/365;
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
		$cycle = Parameter::startAccounting();
		$start = $cycle < now() ? $cycle : $cycle->subYear();
		$hours = 0;
		foreach ($this->positions->where('completed_at', '>=', $start) as $p) {
			$hours += $p->hours;
		}
		return $hours;
	}

	/**
	 * get total number of days of all excemptions in current cycle
	 */
	public function getExcemptionDaysCycleAttribute()
	{
		$cycle = Parameter::startAccounting();
		$start = $cycle < now() ? $cycle : $cycle->subYear();
		$days = 0;
		foreach ($this->excemptions->where('start', '>=', $start) as $e) {
			$begin = Carbon::parse($e->start);
			$end = Carbon::parse($e->end);
			$diff = $begin->diffInDays($end, false);
			if ($diff < 0) continue;
			$days += $diff > 0 ? $diff : 1;
		}
		return $days;
	}

	/**
	 * get total target number of hours for current cycle
	 */
	public function getTotalHoursCycleAttribute()
	{
		$cycle = Parameter::startAccounting();
		$end = $cycle >= now() ? $cycle : $cycle->addYear();
		// $end = new DateTimeImmutable($end->format('Y-m-d'));
		$accountStart = Carbon::parse($this->account->start);
		$start = $accountStart >= $end->subYear() ? $accountStart : $end->subYear();
		$days = $start->diffInDays($end, false) - $this->excemption_days_cycle;
		return $this->target_hours * $days/365;
	}

	/**
	 * get hours still to work to reach quota until end of current cycle
	 */
	public function getMissingHoursCycleAttribute()
	{
		return $this->total_hours_cycle - $this->sum_hours_cycle;
	}

	/**
	 * get status depending on number of hours worked
	 */
	public function getStatusAttribute()
	{
		if ($this->sum_hours_cycle < $this->total_hours_cycle/2) return 0;
		if ($this->sum_hours_cycle < $this->total_hours_cycle) return 1;
		if ($this->sum_hours_cycle >= $this->total_hours_cycle) return 2;
	}
}
