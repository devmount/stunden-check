<?php

use App\Models\Account;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('confirm password screen can be rendered', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this->actingAs($user)->get('/confirm-password');

	$response->assertStatus(200);
});

test('password can be confirmed', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this->actingAs($user)->post('/confirm-password', [
		'password' => 'password',
	]);

	$response->assertRedirect();
	$response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this->actingAs($user)->post('/confirm-password', [
		'password' => 'wrong-password',
	]);

	$response->assertSessionHasErrors();
});
