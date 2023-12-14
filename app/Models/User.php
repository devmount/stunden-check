<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Parameter;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
			$days += count(CarbonPeriod::create($e->start, '1 day', $e->end))-1;
		}
		return $days;
	}

	/**
	 * get total target number of hours
	 */
	public function getTotalHoursAttribute()
	{
		$start = Carbon::parse($this->account->start);
		$days = $start->diffInDays(Parameter::cycleEnd()) - $this->excemption_days;
		return $this->target_hours * round($days/365, 1);
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
		$start = Parameter::cycleStart();
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
		$start = Parameter::cycleStart($this->account->start);
		$end = Parameter::cycleEnd();
		$period = CarbonPeriod::create($start, $end);
		// assumption that at least start or end of excemptions lie within a cycle
		$excemptions = $this->excemptions->filter(
			fn ($e) => $period->contains($e->start) || $period->contains($e->end)
		);
		$days = 0;
		foreach ($excemptions as $e) {
			$days += count(CarbonPeriod::create(max($start, $e->start), '1 day', min($end, $e->end)))-1;
		}
		return $days;
	}

	/**
	 * get total target number of hours for current cycle
	 */
	public function getTotalHoursCycleAttribute()
	{
		$days = Parameter::cycleDays($this->account->start) - $this->excemption_days_cycle;
		return $this->target_hours * $days/Parameter::cycleDays();
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

	/**
	 * get positions in given cycle
	 * @param Carbon  $cycleStart
	 */
	public function positionsByCycle($cycleStart)
	{
		$start = max($this->account->start, $cycleStart);
		return $this->positions->where('completed_at', '>=', $start);
	}

	/**
	 * get sum of hours in given cycle
	 * @param Carbon  $cycleStart
	 */
	public function sumHoursByCycle($cycleStart)
	{
		$start = max($this->account->start, $cycleStart);
		$hours = 0;
		foreach ($this->positionsByCycle($start) as $p) {
			$hours += $p->hours;
		}
		return $hours;
	}

	/**
	 * get total number of days of all excemptions in given cycle
	 * @param Carbon  $cycleStart
	 */
	public function excemptionDaysByCycle($cycleStart)
	{
		$start = max($this->account->start, $cycleStart);
		$end = Carbon::create($cycleStart)->addYear()->subDay();
		$period = CarbonPeriod::create($start, $end);
		// assumption that at least start or end of excemptions lie within a cycle
		$excemptions = $this->excemptions->filter(
			fn ($e) => $period->contains($e->start) || $period->contains($e->end)
		);
		$days = 0;
		foreach ($excemptions as $e) {
			// TODO: only count days that are inside the valid working period of the user
			$days += count(CarbonPeriod::create(max($start, $e->start), '1 day', min($end, $e->end)))-1;
		}
		return $days;
	}

	/**
	 * get total target number of hours for given cycle
	 */
	public function totalHoursByCycle($cycleStart)
	{
		$start = max($this->account->start, $cycleStart);
		$end = Carbon::create($cycleStart)->addYear()->subDay();
		$days = Carbon::create($start)->diffInDays($end) - $this->excemptionDaysByCycle($start);
		$hours = $this->target_hours * round($days/Parameter::cycleDays(), 1);
		return $hours; // TODO: handle given cycle days
	}

	/**
	 * get hours still to work to reach quota until end of given cycle
	 */
	public function missingHoursByCycle($cycleStart)
	{
		return $this->totalHoursByCycle($cycleStart) - $this->sumHoursByCycle($cycleStart);
	}

	/**
	 * get status depending on number of hours worked in given cycle
	 */
	public function statusByCycle($cycleStart)
	{
		if ($this->sumHoursByCycle($cycleStart) < $this->totalHoursByCycle($cycleStart)/2) return 0;
		if ($this->sumHoursByCycle($cycleStart) < $this->totalHoursByCycle($cycleStart)) return 1;
		if ($this->sumHoursByCycle($cycleStart) >= $this->totalHoursByCycle($cycleStart)) return 2;
	}
}
