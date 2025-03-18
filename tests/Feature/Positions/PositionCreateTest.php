<?php

use App\Models\Account;
use App\Models\Position;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('position create page can be rendered', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this->actingAs($user)->get('/positions/add');

	$response->assertOk();
});


test('position can be added and go back', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/positions/add', [
			'completed_at' => '2025-01-05',
			'hours' => 5.5,
			'category_id' => 1,
			'description' => 'Lorem Ipsum',
			'go_back' => true,
		]);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/');

	$position = Position::find(1);
	expect($position->description)->toBe('Lorem Ipsum');
	expect($position->user->id)->toBe($user->id);
	expect($position->category->id)->toBe(1);
});


test('position can be added and stay', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/positions/add', [
			'completed_at' => '2025-01-05',
			'hours' => 5.5,
			'category_id' => 1,
			'description' => 'Lorem Ipsum',
		]);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/positions/add');
});


test('required parameters are missing', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/positions/add', [
			'completed_at' => null,
			'hours' => null,
			'category_id' => null,
			'description' => null,
		]);

	$response
		->assertSessionHasErrors('completed_at')
		->assertSessionHasErrors('hours')
		->assertSessionHasErrors('category_id')
		->assertSessionHasErrors('description')
		->assertRedirect('/');

});
