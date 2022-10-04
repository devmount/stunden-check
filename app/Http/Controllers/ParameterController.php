<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Parameter  $parameter
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Parameter $parameter)
	{
		$parameters = [];
		// build key value pairs
		foreach (Parameter::all() as $p) {
			$parameters[$p->key] = $p->value;
		}
		return view('parameters', compact('parameters'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Parameter  $parameter
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Parameter $parameter)
	{
		$request->validate($this->rules());

		// update each parameter
		Parameter::upsert([
			['key' => 'cycle_accounting', 'value' => $request->input('cycle_accounting')],
			['key' => 'start_accounting', 'value' => $request->input('start_accounting')],
			['key' => 'target_hours',     'value' => $request->input('target_hours')    ],
			['key' => 'cycle_reminder',   'value' => $request->input('cycle_reminder')  ],
			['key' => 'start_reminder',   'value' => $request->input('start_reminder')  ]
		], ['key'], ['value']);

		return redirect()->route('settings')->with('status', 'Die Einstellungen wurden gespeichert.');
	}

	/**
	 * Ruleset for validation of parameters
	 *
	 * @return Array
	 */
	private function rules()
	{
		return [
			'cycle_accounting' => 'required|string',
			'start_accounting' => 'required|date',
			'target_hours'     => 'required|numeric',
			'cycle_reminder'   => 'required|string',
			'start_reminder'   => 'required|numeric',
		];
	}
}
