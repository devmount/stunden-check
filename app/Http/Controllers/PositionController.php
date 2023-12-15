<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Parameter;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PositionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$start        = $request->has('start') ? $request->date('start') : Parameter::cycleStart();
		$u            = User::find(auth()->user()->id);
		$a            = $u->account;
		$separate     = $a->separate_accounting;
		$p            = $u->partner;
		$total_sum    = $separate ? $u->sum_hours                   : $a->sum_hours;
		$total_target = $separate ? $u->total_hours                 : $a->total_hours;
		$missing      = $separate ? $u->missingHoursByCycle($start) : $a->missingHoursByCycle($start);
		$cycle_sum    = $separate ? $u->sumHoursByCycle($start)     : $a->sumHoursByCycle($start);
		$cycle_target = $separate ? $u->totalHoursByCycle($start)   : $a->totalHoursByCycle($start);

		return view('dashboard')
			->with('selectedStart', $start)
			->with('selectedEnd', Carbon::create($start)->addYear()->subDay())
			->with('user', $u)
			->with('user_positions', $u->positionsByCycle($start))
			->with('partner', $p)
			->with('partner_positions', $p?->positionsByCycle($start))
			->with('total_sum', $total_sum)
			->with('total_target', round($total_target, 1))
			->with('missing', $missing >= 0 ? round($missing, 1) : 0)
			->with('cycle_sum', round($cycle_sum, 1))
			->with('cycle_target', round($cycle_target, 1))
			->with('categories', Category::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('positions-form')
			->with('categories', Category::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate($this->rules());

		User::find(auth()->user()->id)->positions()->create([
			'completed_at' => $request->input('completed_at'),
			'hours'        => $request->input('hours'),
			'category_id'  => $request->input('category_id'),
			'description'  => $request->input('description'),
		]);
		return redirect()
			->route($request->has('go_back') ? 'dashboard' : 'positions-add')
			->with('status', 'Der Eintrag wurde erfolgreich angelegt.');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Integer  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$position = Position::find($id);

		// check if user is allowed to edit the position
		if (!auth()->user()->is_admin && $position->user->id !== auth()->user()->id) {
			return redirect()
				->route('dashboard')
				->with('status', 'Dieser Eintrag gehört dir nicht.');
		}
		// go to edit the position
		return view('positions-form', compact('position'))
			->with('categories', Category::all());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Integer  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$position = Position::find($id);

		// check if user is allowed to update the position
		if (!auth()->user()->is_admin && $position->user->id !== auth()->user()->id) {
			return redirect()
				->route('dashboard')
				->with('status', 'Dieser Eintrag gehört dir nicht.');
		}

		$request->validate($this->rules());

		$position->completed_at = $request->input('completed_at');
		$position->hours        = $request->input('hours');
		$position->category_id  = $request->input('category_id');
		$position->description  = $request->input('description');
		$position->save();

		return redirect()
			->route($request->has('go_back') ? 'dashboard' : 'positions-add')
			->with('status', 'Der Eintrag wurde erfolgreich aktualisiert.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Integer  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$position = Position::find($id);

		// check if user is allowed to delete the position
		if (!auth()->user()->is_admin && $position->user->id !== auth()->user()->id) {
			return redirect()
				->route('dashboard')
				->with('status', 'Dieser Eintrag gehört dir nicht.');
		}

		$position->delete();

		return redirect()
			->route('dashboard')
			->with('status', 'Der Eintrag wurde erfolgreich gelöscht.');
	}

	/**
	 * Ruleset for validation of accounts and associated user models
	 *
	 * @return Array
	 */
	private function rules()
	{
		return [
			'completed_at' => 'required|date',
			'hours'        => 'required|numeric',
			'category_id'  => 'required|numeric',
			'description'  => 'required|string',
			'go_back'      => 'nullable|boolean',
		];
	}
}
