<?php

use App\Enums\DateCycle;
use App\Models\Account;
use App\Models\Parameter;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('settings page can be rendered for admins', function () {
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

	expect(Parameter::key('branding_title'))->toBe('Brand');
	expect(Parameter::key('tasks_url'))->toBe('https://exmaple.com');
	expect(Parameter::key('cycle_accounting'))->toBe('semiannual');
	expect(Parameter::key('start_accounting'))->toBe('2024-08-01');
	expect(Parameter::key('target_hours'))->toBe('24');
	expect(Parameter::key('cycle_reminder'))->toBe('monthly');
	expect(Parameter::key('start_reminder'))->toBe('1');
	expect(Parameter::cycles())->toBeArray();
});


test('required parameters are missing', function () {
	$account = Account::factory()->create();
	$user = User::factory()->admin()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/settings', [
			'branding_title' => null,
			'tasks_url' => null,
			'cycle_accounting' => null,
			'start_accounting' => null,
			'target_hours' => null,
			'cycle_reminder' => null,
			'start_reminder' => null,
		]);

	$response
		->assertSessionHasErrors('cycle_accounting')
		->assertSessionHasErrors('start_accounting')
		->assertSessionHasErrors('target_hours')
		->assertSessionHasErrors('cycle_reminder')
		->assertSessionHasErrors('start_reminder')
		->assertRedirect('/');

});


test('test mail can be sent', function () {
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->post('/test/mail', ['testmail' => 'mail@example.com']);
	$response->assertRedirect('/settings?view=email');

	$response = $this
		->actingAs(User::factory()->create())
		->post('/test/mail');
	$response->assertRedirect('/');
});
