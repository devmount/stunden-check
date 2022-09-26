<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
	/**
	 * Display a listing of accounts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$accounts = Account::with('users')->get();
		return view('accounts')->with('accounts', $accounts);
	}

	/**
	 * Handle an incoming account request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$request->validate([
			'active'             => 'nullable|boolean',
			'separateAccounting' => 'nullable|boolean',
			'start'              => 'required|date',
			'targetHours'        => 'required|numeric',
			'firstname1'         => 'required|string|max:255',
			'lastname1'          => 'required|string|max:255',
			'email1'             => 'required|string|email|max:255|unique:users',
			'isAdmin1'           => 'nullable|boolean',
			'firstname2'         => 'required_with_all:lastname2,email2|string|max:255',
			'lastname2'          => 'required_with_all:firstname2,email2|string|max:255',
			'email2'             => 'required_with_all:firstname2,lastname2|string|email|max:255|unique:users',
			'isAdmin2'           => 'nullable|boolean',
		]);
		// return back()->withInput();

		$account = Account::create([
			'active' => $request->active,
			'separateAccounting' => $request->separateAccounting,
			'start' => $request->start,
			'targetHours' => $request->targetHours,
		]);

		$user1 = User::create([
			'accountId' => $account->id,
			'firstname' => $request->firstname1,
			'lastname' => $request->lastname1,
			'email' => $request->email1,
			'password' => Hash::make('test'),
			'isAdmin' => $request->isAdmin1,
		]);
		
		if ($request->firstname2 && $request->lastname2 && $request->email2) {
			$user2 = User::create([
				'accountId' => $account->id,
				'firstname' => $request->firstname2,
				'lastname' => $request->lastname2,
				'email' => $request->email2,
				'isAdmin' => $request->isAdmin2,
			]);
		}

		return back();
	}
}
