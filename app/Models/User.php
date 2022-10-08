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
	 * get hours still to work to reach quota until end of current cycle
	 */
	public function getMissingHoursAttribute()
	{
		$cycle = new DateTime(Parameter::key('start_accounting'));
		$end = $cycle >= now() ? $cycle : $cycle->modify('+1 year');
		$start = new DateTime($this->account->start);
		$years = $start->diff($end)->y;
		return $this->account->target_hours*$years - $this->sum_hours;
	}

	/**
	 * get sum of hours in current cycle
	 */
	public function getCycleHoursAttribute()
	{
		$cycle = new DateTime(Parameter::key('start_accounting'));
		$start = $cycle < now() ? $cycle : $cycle->modify('-1 year');
		$hours = 0;
		foreach ($this->positions->where('completed_at', '>', $start->format('Y-m-d')) as $p) {
			$hours += $p->hours;
		}
		return $hours;
	}

}
