<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
	/**
	 * Display a listing of accounts with assigned users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$accounts = Account::with('users')->get();
		return view('accounts')->with('accounts', $accounts);
	}

	/**
	 * Display the account creation view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('accounts-form');
	}

	/**
	 * Handle an incoming account request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$request->validate($this->rules());

		$account = Account::create([
			'active'              => $request->has('active'),
			'separate_accounting' => $request->has('separate_accounting'),
			'start'               => $request->input('start'),
			'target_hours'        => $request->input('target_hours'),
		]);

		$account->users()->create([
			'firstname'           => $request->input('firstname1'),
			'lastname'            => $request->input('lastname1'),
			'email'               => $request->input('email1'),
			'password'            => Hash::make('test'),
			'is_admin'            => $request->has('is_admin1'),
		]);
		
		if ($request->firstname2 && $request->lastname2 && $request->email2) {
			$account->users()->create([
				'firstname'         => $request->input('firstname2'),
				'lastname'          => $request->input('lastname2'),
				'email'             => $request->input('email2'),
				'password'          => Hash::make('test'),
				'is_admin'          => $request->has('is_admin2'),
			]);
		}

		return redirect()->route('accounts')->with('status', 'Das Konto wurde erfolgreich angelegt.');
	}

	/**
	 * Display the account modification view.
	 *
	 * @param Integer  $id
	 * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$account = Account::find($id);
		return view('accounts-form', compact('account'));
	}

	/**
	 * Handle an incoming account request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Integer  $id
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function update(Request $request, $id)
	{
		$account = Account::find($id);
		$uid1 = isset($account->users[0]) ? $account->users[0]->id : null;
		$uid2 = isset($account->users[1]) ? $account->users[1]->id : null;

		$request->validate($this->rules($uid1, $uid2));

		$account->active              = $request->has('active');
		$account->separate_accounting = $request->has('separate_accounting');
		$account->start               = $request->input('start');
		$account->target_hours        = $request->input('target_hours');

		$account->users[0]->firstname = $request->input('firstname1');
		$account->users[0]->lastname  = $request->input('lastname1');
		$account->users[0]->email     = $request->input('email1');
		$account->users[0]->is_admin  = $request->has('is_admin1');

		if ($request->firstname2 && $request->lastname2 && $request->email2) {
			if (isset($account->users[1])) {
				$account->users[1]->firstname = $request->input('firstname2');
				$account->users[1]->lastname  = $request->input('lastname2');
				$account->users[1]->email     = $request->input('email2');
				$account->users[1]->is_admin  = $request->has('is_admin2');
			} else {
				$account->users()->create([
					'firstname'         => $request->input('firstname2'),
					'lastname'          => $request->input('lastname2'),
					'email'             => $request->input('email2'),
					'password'          => Hash::make('test'),
					'is_admin'          => $request->has('is_admin2'),
				]);
			}
		}

		$account->push();

		return redirect()->route('accounts')->with('status', 'Das Konto wurde erfolgreich aktualisiert.');
	}

	/**
	 * Ruleset for validation of accounts and associated user models
	 *
	 * @param  Integer  $uid1
	 * @param  Integer  $uid2
	 * @return Array
	 */
	private function rules($uid1 = null, $uid2 = null)
	{
		return [
			'active'              => 'nullable|boolean',
			'separate_accounting' => 'nullable|boolean',
			'start'               => 'required|date',
			'target_hours'        => 'required|numeric',
			'firstname1'          => 'required|string|max:255',
			'lastname1'           => 'required|string|max:255',
			'email1'              => 'required|string|email|max:255|unique:users,email' . ($uid1 ? ',' . $uid1 : ''),
			'is_admin1'           => 'nullable|boolean',
			'firstname2'          => 'nullable|string|max:255',
			'lastname2'           => 'nullable|string|max:255',
			'email2'              => 'nullable|string|email|max:255|unique:users,email' . ($uid2 ? ',' . $uid2 : ''),
			'is_admin2'           => 'nullable|boolean',
		];
	}
}
