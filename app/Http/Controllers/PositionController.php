<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class PositionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$u        = auth()->user();
		$a        = $u->account;
		$separate = $a->separate_accounting;
		$p        = count($a->users) > 1 && !$separate ? $a->users[1] : null;
		$sum      = $separate ? $u->sum_hours       : $a->sum_hours;
		$missing  = $separate ? $u->missing_hours   : $a->missing_hours;
		$cycle    = $separate ? $u->sum_hours_cycle : $a->sum_hours_cycle;
		$total    = $separate ? $u->total_hours     : $a->total_hours;

		return view('dashboard')
			->with('user', $u)
			->with('partner', $p)
			->with('sum', $sum)
			->with('missing', $missing >= 0 ? round($missing, 1) : 0)
			->with('cycle', round($cycle, 1))
			->with('total', round($total, 1))
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
			->route('dashboard')
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
