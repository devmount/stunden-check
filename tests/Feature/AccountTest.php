<?php

use App\Models\Account;
use App\Models\Parameter;
use App\Models\User;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertIsInt;
use function PHPUnit\Framework\assertIsNumeric;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNull;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('account query can be scoped', function () {
	Account::factory(4)->create();
	Account::factory(6)->archived()->create();

	expect(Account::all()->count())->toBe(11);
	expect(Account::active()->count())->toBe(5);
	expect(Account::archived()->count())->toBe(6);
});


test('account create page can be rendered for admins only', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();
	$admin = User::find(1);

	$response = $this->actingAs($user)->get('/accounts/add');
	$response->assertRedirect('/');

	$response = $this->actingAs($admin)->get('/accounts/add');
	$response->assertOk();
});


test('account can be added', function () {
	$account = Account::factory()->create();
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->post('/accounts/add', [
			'start' => '2025-01-05',
			'target_hours' => 5.5,
			'firstname1' => 'Peter',
			'lastname1' => 'Shaw',
			'email1' => 'peter.shaw@questionmarks.com',
		]);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/accounts');

	$start = Parameter::cycleStart();
	$account = Account::all()->last();
	expect($account->start)->toBe('2025-01-05');
	assertArrayHasKey(0, $account->users);
	assertIsNumeric($account->sum_hours);
	assertIsNumeric($account->excemption_days);
	assertIsNumeric($account->total_hours);
	assertIsNumeric($account->missing_hours);
	assertIsNumeric($account->sumHoursByCycle($start));
	assertIsNumeric($account->excemptionDaysByCycle($start));
	assertIsNumeric($account->totalHoursByCycle($start));
	assertIsNumeric($account->missingHoursByCycle($start));
	assertIsInt($account->statusByCycle($start));
});


test('account edit page can be rendered for admins only', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();
	$admin = User::find(1);

	$response = $this->actingAs($user)->get('/accounts/edit/1');
	$response->assertRedirect('/');

	$response = $this->actingAs($admin)->get('/accounts/edit/1');
	$response->assertOk();
});


test('account can be edited', function () {
	$account = Account::factory()->has(User::factory(2))->create();
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->post('/accounts/edit/' . Account::all()->last()->id, [
			'start' => '2025-01-05',
			'target_hours' => 5.5,
			'firstname1' => 'Peter',
			'lastname1' => 'Shaw',
			'email1' => 'peter.shaw@questionmarks.com',
		]);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/accounts');

	$start = Parameter::cycleStart();
	$account = Account::all()->last();
	expect($account->start)->toBe('2025-01-05');
	assertArrayHasKey(0, $account->users);
	assertIsNumeric($account->sum_hours);
	assertIsNumeric($account->excemption_days);
	assertIsNumeric($account->total_hours);
	assertIsNumeric($account->missing_hours);
	assertIsNumeric($account->sumHoursByCycle($start));
	assertIsNumeric($account->excemptionDaysByCycle($start));
	assertIsNumeric($account->totalHoursByCycle($start));
	assertIsNumeric($account->missingHoursByCycle($start));
	assertIsInt($account->statusByCycle($start));
});


test('account can be archived', function () {
	$account = Account::factory()->create();
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->post('/accounts/archive/' . Account::all()->last()->id);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/accounts');

	$account = Account::all()->last();
	expect($account->active)->toBe(0);
	assertNotEmpty($account->archived_at);
});


test('account can be recycled', function () {
	$accountId = Account::factory()->archived()->create()->id;
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->get('/accounts/recycle/' . $accountId);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/accounts');

	$account = Account::find($accountId);
	expect($account->active)->toBe(1);
});


test('account can be deleted', function () {
	$account = Account::factory()->has(User::factory(2))->create();
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->post('/accounts/delete/' . $account->id);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/accounts');

	assertNull(Account::find($account->id));
	assertEmpty($account->users);
});


test('accounts reminder can be rendered for admins', function () {
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->get('/accounts/reminder');
	$response->assertOk();

	$response = $this
		->actingAs(User::factory()->create())
		->get('/accounts/reminder');
	$response->assertRedirect('/');
});


test('accounts reminder can be sent', function () {
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->post('/accounts/reminder');
	$response->assertRedirect('/accounts');

	$response = $this
		->actingAs(User::factory()->create())
		->post('/accounts/reminder');
	$response->assertRedirect('/');
});


test('accounts can be exported', function () {
	$admin = User::find(1);

	$response = $this
		->actingAs($admin)
		->get('/accounts/export/xlsx/2024-01-01');
	$response->assertOk();

	$response = $this
		->actingAs(User::factory()->create())
		->get('/accounts/export/xlsx/2024-01-01');
	$response->assertRedirect('/');

	$response = $this
		->actingAs($admin)
		->get('/accounts/export/csv/2024-01-01');
	$response->assertOk();

	$response = $this
		->actingAs(User::factory()->create())
		->get('/accounts/export/csv/2024-01-01');
	$response->assertRedirect('/');
});
