<?php

namespace App\Http\Controllers;

use App\Models\Position;
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
		return view('dashboard')
			->with('positions', auth()->user()->positions)
			->with('categories', Category::get());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('positions-form')
			->with('categories', Category::get());
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

		auth()->user()->positions()->create([
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
		return view('positions-form', compact('position'))
			->with('categories', Category::get());
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

		$request->validate($this->rules());

		$position->completed_at = $request->input('completed_at');
		$position->hours        = $request->input('hours');
		$position->category_id  = $request->input('category_id');
		$position->description  = $request->input('description');
		$position->save();
		error_log(json_encode($position));

		return redirect()
			->route($request->has('go_back') ? 'dashboard' : 'positions-add')
			->with('status', 'Der Eintrag wurde erfolgreich aktualisiert.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Position  $position
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Position $position)
	{
		//
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
		];
	}
}
