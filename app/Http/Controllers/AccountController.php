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
		$request->validate([
			'active'              => 'nullable|boolean',
			'separate_accounting' => 'nullable|boolean',
			'start'               => 'required|date',
			'target_hours'        => 'required|numeric',
			'firstname1'          => 'required|string|max:255',
			'lastname1'           => 'required|string|max:255',
			'email1'              => 'required|string|email|max:255|unique:users',
			'is_admin1'           => 'nullable|boolean',
			'firstname2'          => 'nullable|string|max:255',
			'lastname2'           => 'nullable|string|max:255',
			'email2'              => 'nullable|string|email|max:255|unique:users',
			'is_admin2'           => 'nullable|boolean',
		]);

		$account = Account::create([
			'active'              => $request->has('active'),
			'separate_accounting' => $request->has('separate_accounting'),
			'start'               => $request->start,
			'target_hours'        => $request->target_hours,
		]);

		$account->users()->create([
			'firstname'           => $request->firstname1,
			'lastname'            => $request->lastname1,
			'email'               => $request->email1,
			'password'            => Hash::make('test'),
			'is_admin'            => $request->has('is_admin1'),
		]);
		
		if ($request->firstname2 && $request->lastname2 && $request->email2) {
			$account->users()->create([
				'firstname'         => $request->firstname2,
				'lastname'          => $request->lastname2,
				'email'             => $request->email2,
				'password'          => Hash::make('test'),
				'is_admin'          => $request->has('is_admin2'),
			]);
		}

		return redirect()->route('accounts');
	}
}
