<?php

use App\Enums\DateCycle;
use App\Models\Account;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('settings page is displayed for admins', function () {
	$account = Account::factory()->create();
	$user = User::factory()->admin()->for($account)->create();

	$response = $this->actingAs($user)->get('/settings');

	$response->assertOk();
});

test('settings page is forbidden for non-admins', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this->actingAs($user)->get('/settings');

	$response->assertRedirect('/');
});

test('all parameters can be updated', function () {
	$account = Account::factory()->create();
	$user = User::factory()->admin()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/settings', [
			'branding_title' => 'Brand',
			'tasks_url' => 'https://exmaple.com',
			'cycle_accounting' => DateCycle::Semiannual->value,
			'start_accounting' => '2024-08-01',
			'target_hours' => 24,
			'cycle_reminder' => DateCycle::Monthly->value,
			'start_reminder' => 1,
		]);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/settings');
});
