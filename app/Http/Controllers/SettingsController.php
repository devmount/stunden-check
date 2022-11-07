<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Category;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
	/**
	 * Show settings.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$parameters = [];
		// build key value pairs
		foreach (Parameter::all() as $p) {
			$parameters[$p->key] = $p->value;
		}
		return view('settings', compact('parameters'))
			->with('categories', Category::all())
			->with('view', $request->query('view'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$request->validate($this->rules());

		// update each parameter
		Parameter::upsert([
			['key' => 'branding_title',   'value' => $request->input('branding_title')  ],
			['key' => 'cycle_accounting', 'value' => $request->input('cycle_accounting')],
			['key' => 'start_accounting', 'value' => $request->input('start_accounting')],
			['key' => 'target_hours',     'value' => $request->input('target_hours')    ],
			['key' => 'cycle_reminder',   'value' => $request->input('cycle_reminder')  ],
			['key' => 'start_reminder',   'value' => $request->input('start_reminder')  ]
		], ['key'], ['value']);

		return redirect()->route('settings')->with('status', 'Die Einstellungen wurden gespeichert.');
	}

	/**
	 * Test sending emails
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function send(Request $request)
	{
		$request->validate([
			'testmail' => 'required|string|email'
		]);

		// send test mail
		Mail::to($request->input('testmail'))->send(new TestMail());

		return redirect()->route('settings', ['view' => 'email'])
			->with('status', 'Die Test-E-Mail wurde versandt.');
	}

	/**
	 * Ruleset for validation of parameters
	 *
	 * @return Array
	 */
	private function rules()
	{
		return [
			'branding_title'   => 'string',
			'cycle_accounting' => 'required|string',
			'start_accounting' => 'required|date',
			'target_hours'     => 'required|numeric',
			'cycle_reminder'   => 'required|string',
			'start_reminder'   => 'required|numeric',
		];
	}
}
