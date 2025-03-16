<?php

use App\Models\Account;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('login screen can be rendered', function () {
	$response = $this->get('/login');

	$response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
	$user = User::find(1);

	$response = $this->post('/login', [
		'email' => $user->email,
		'password' => 'Joh.3,16',
	]);

	$this->assertAuthenticated();
	$response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
	$user = User::find(1);

	$this->post('/login', [
		'email' => $user->email,
		'password' => 'wrong-password',
	]);

	$this->assertGuest();
});

test('users can logout', function () {
	$user = User::find(1);

	$response = $this->actingAs($user)->post('/logout');

	$this->assertGuest();
	$response->assertRedirect('/');
});
