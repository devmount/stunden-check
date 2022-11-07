<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Position;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('categories-form');
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

		Category::create([
			'title'       => $request->input('title'),
			'description' => $request->input('description'),
		]);
		return redirect()
			->route('settings', ['view' => 'cat'])
			->with('status', 'Der Bereich wurde erfolgreich angelegt.');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$category = Category::find($id);

		// go to edit the category
		return view('categories-form', compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$category = Category::find($id);

		$request->validate($this->rules());

		$category->title       = $request->input('title');
		$category->description = $request->input('description');
		$category->save();

		return redirect()
			->route('settings', ['view' => 'cat'])
			->with('status', 'Der Bereich wurde erfolgreich aktualisiert.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete(Request $request, $id)
	{
		$category = Category::find($id);
		$request->validate(['replacement' => 'required|numeric']);

		// get and update all positions currently holding the category to delete
		$positions = Position::where('category_id', $id)->get();
		if (!empty($positions)) {
			$positions->toQuery()->update([
				'category_id' => $request->input('replacement'),
			]);
		}
		// now the category can be removed, as it's no longer used
		$category->delete();
		return redirect()
			->route('settings', ['view' => 'cat'])
			->with('status', 'Der Bereich wurde erfolgreich gelöscht.');
	}

	/**
	 * Ruleset for validation of accounts and associated user models
	 *
	 * @return Array
	 */
	private function rules()
	{
		return [
			'title'       => 'required|string',
			'description' => 'required|string',
		];
	}
}
