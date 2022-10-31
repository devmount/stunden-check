<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Excemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountController extends Controller
{
	/**
	 * Display a listing of accounts with assigned users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$activeAccounts = Account::active()->with('users')->get();
		$archivedAccounts = Account::archived()->with('users')->get();
		return view('accounts')
			->with('activeAccounts', $activeAccounts)
			->with('archivedAccounts', $archivedAccounts);
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
	 * Handle an incoming account creation request.
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

		$pass1 = Str::random(12);
		$user1 = $account->users()->create([
			'firstname'           => $request->input('firstname1'),
			'lastname'            => $request->input('lastname1'),
			'email'               => $request->input('email1'),
			'password'            => Hash::make($pass1),
			'is_admin'            => $request->has('is_admin1'),
		]);
		// TODO send mail with initial password
		if (count($request->ex_start1) > 0 && count($request->ex_start1) == count($request->ex_end1)) {
			for ($i=0; $i < count($request->ex_start1); $i++) { 
				$user1->excemptions()->create([
					'start'           => $request->ex_start1[$i],
					'end'             => $request->ex_end1[$i],
				]);
			}
		}

		if ($request->firstname2 && $request->lastname2 && $request->email2) {
			$pass2 = Str::random(12);
			$user2 = $account->users()->create([
				'firstname'         => $request->input('firstname2'),
				'lastname'          => $request->input('lastname2'),
				'email'             => $request->input('email2'),
				'password'          => Hash::make($pass2),
				'is_admin'          => $request->has('is_admin2'),
			]);
			// TODO send mail with initial password
			if (count($request->ex_start2) > 0 && count($request->ex_start2) == count($request->ex_end2)) {
				for ($i=0; $i < count($request->ex_start2); $i++) { 
					$user2->excemptions()->create([
						'start'         => $request->ex_start2[$i],
						'end'           => $request->ex_end2[$i],
					]);
				}
			}
		}

		return redirect()
			->route('accounts')
			->with('status', 'Das Konto wurde erfolgreich angelegt.');
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
	 * Handle an incoming account modification request.
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

		// handle account
		$account->active              = $request->has('active');
		$account->separate_accounting = $request->has('separate_accounting');
		$account->start               = $request->input('start');
		$account->target_hours        = $request->input('target_hours');

		// handle first person
		$account->users[0]->firstname = $request->input('firstname1');
		$account->users[0]->lastname  = $request->input('lastname1');
		$account->users[0]->email     = $request->input('email1');
		$account->users[0]->is_admin  = $request->has('is_admin1');

		// handle excemptions for first person
		if (!empty($request->ex_delete1)) {
			$ids = array_map('intval', explode(',', $request->ex_delete1));
			Excemption::destroy($ids);
		}
		if ($request->ex_start1 && count($request->ex_start1) > 0 && count($request->ex_start1) == count($request->ex_end1)) {
			for ($i=0; $i < count($request->ex_start1); $i++) { 
				$account->users[0]->excemptions()->create([
					'start' => $request->ex_start1[$i],
					'end'   => $request->ex_end1[$i],
				]);
			}
		}

		// handle second person
		if ($request->firstname2 && $request->lastname2 && $request->email2) {
			if (isset($account->users[1])) {
				$account->users[1]->firstname = $request->input('firstname2');
				$account->users[1]->lastname  = $request->input('lastname2');
				$account->users[1]->email     = $request->input('email2');
				$account->users[1]->is_admin  = $request->has('is_admin2');
			} else {
				$account->users()->create([
					'firstname' => $request->input('firstname2'),
					'lastname'  => $request->input('lastname2'),
					'email'     => $request->input('email2'),
					'password'  => Hash::make('test'),
					'is_admin'  => $request->has('is_admin2'),
				]);
			}

			// handle excemptions for second person
			if (!empty($request->ex_delete2)) {
				$ids = array_map('intval', explode(',', $request->ex_delete2));
				Excemption::destroy($ids);
			}
			if ($request->ex_start2 && count($request->ex_start2) > 0 && count($request->ex_start2) == count($request->ex_end2)) {
				for ($i=0; $i < count($request->ex_start2); $i++) { 
					$account->users[1]->excemptions()->create([
						'start' => $request->ex_start2[$i],
						'end'   => $request->ex_end2[$i],
					]);
				}
			}
		}

		$account->push();

		return redirect()
			->route('accounts')
			->with('status', 'Das Konto wurde erfolgreich aktualisiert.');
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
	public function archive(Request $request, $id)
	{
		$account = Account::find($id);
		$account->active = false;
		$account->archived_at = now();
		$account->save();

		return redirect()
			->route('accounts')
			->with('status', 'Das Konto wurde erfolgreich archiviert.');
	}

	/**
	 * Handle an incoming account recycling request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Integer  $id
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function recycle(Request $request, $id)
	{
		$account = Account::find($id);
		$account->active = true;
		$account->save();

		return redirect()
			->route('accounts')
			->with('status', 'Das Konto wurde erfolgreich reaktiviert.');
	}

	/**
	 * Handle an incoming account deletion request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Integer  $id
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function delete(Request $request, $id)
	{
		$account = Account::find($id);
		$account->delete();

		return redirect()
			->route('accounts')
			->with('status', 'Das Konto wurde erfolgreich gelöscht.');
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
			'ex_start'            => 'nullable|array',
			'ex_end'              => 'nullable|array',
			'ex_delete'           => 'nullable|string',
		];
	}
}
