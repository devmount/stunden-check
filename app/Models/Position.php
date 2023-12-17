<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Position extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'category_id',
		'completed_at',
		'hours',
		'description',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'user_id',
	];

	/**
	 * Get the user that created/worked this position.
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Get the category of this positions.
	 */
	public function category()
	{
		return $this->belongsTo('App\Models\Category');
	}

	/**
	 * Scope a query to only include positions in given cycle.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByCycle(Builder $query, Carbon|string $cycleStart)
	{
		$start = Carbon::create($cycleStart);
		$end = Carbon::create($cycleStart)->addYear()->subDay();
		return $query->where('completed_at', '>=', $start)->where('completed_at', '<=', $end);
	}

	/**
	 * Scope a query to only include positions before accounting was even started (invalid positions).
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeBeforeBeginning(Builder $query)
	{
		$start = Carbon::create(Parameter::key('start_accounting'));
		return $query->where('completed_at', '<', $start);
	}
}
