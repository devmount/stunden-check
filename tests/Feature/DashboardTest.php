<?php

use App\Models\Account;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
	$response = $this->get('/');
	$response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();
	$this->actingAs($user);

	$response = $this->get('/');
	$response->assertStatus(200);
});
