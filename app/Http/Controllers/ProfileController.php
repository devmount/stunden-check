<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
	/**
	 * Display a profile information of current users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('profile');
	}

	/**
	 * Display password modification view.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function password()
	{
		return view('password');
	}

	/**
	 * Handle an incoming account archive request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Integer  $id
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function update(Request $request)
	{
		$request->validate([
			'pass'    => 'required|string',
			'newpass' => 'required|string|confirmed|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
		]);
		
		$user = User::find(auth()->user()->id);

		if (Hash::check($request->input('pass'), $user->password)) {
			$user->password = Hash::make($request->input('newpass'));
			$user->save();
			return redirect()
				->route('profile')
				->with('status', 'Dein Passwort wurde erfolgreich aktualisiert.');
		} else {
			throw ValidationException::withMessages(['pass' => 'Dein altes Passwort war nicht korrekt.']);
		}
			
		return redirect()->route('password.change');
	}
}
