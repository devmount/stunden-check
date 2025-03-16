<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('profile page is displayed', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this
		->actingAs($user)
		->get('/profile');

	$response->assertOk();
});

test('password can be updated', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this
		->actingAs($user)
		->from('/profile/password')
		->post('/profile/password', [
			'pass' => 'password',
			'newpass' => 'passPASS1234',
			'newpass_confirmation' => 'passPASS1234',
		]);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/profile');

	expect(Hash::check('passPASS1234', $user->refresh()->password))->toBeTrue();
});

test('correct password must be provided to update password', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this
		->actingAs($user)
		->from('/profile/password')
		->post('/profile/password', [
			'pass' => 'wrong-password',
			'newpass' => 'passPASS1234',
			'newpass_confirmation' => 'passPASS1234',
		]);

	$response
		->assertSessionHasErrors('pass')
		->assertRedirect('/profile/password');
});
