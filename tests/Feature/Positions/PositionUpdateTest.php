<?php

use App\Models\Account;
use App\Models\Position;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('position edit page can be rendered by owner', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();
	$position = Position::factory()->for($user)->create();

	$response = $this->actingAs($user)->get("/positions/edit/$position->id");

	$response->assertOk();
});


test('position edit page can be rendered only by owner or admin', function () {
	$account = Account::factory()->create();
	$owner = User::factory()->for($account)->create();
	$position = Position::factory()->for($owner)->create();

	$foreignAccount = Account::factory()->create();
	$user = User::factory()->for($foreignAccount)->create();
	$admin = User::factory()->admin()->for($foreignAccount)->create();

	$response = $this->actingAs($user)->get("/positions/edit/$position->id");
	$response->assertRedirect('/');

	$response = $this->actingAs($admin)->get("/positions/edit/$position->id");
	$response->assertOk();
});


test('position can be updated by owner', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();
	$position = Position::factory()->for($user)->create();

	$response = $this
		->actingAs($user)
		->post("/positions/edit/$position->id", [
			'completed_at' => '2025-01-05',
			'hours' => 5.5,
			'category_id' => 1,
			'description' => 'Lorem Ipsum',
		]);

	expect(Position::find($position->id)->hours)->toBe(5.5);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/positions/add');
});


test('position can be only updated by owner or admin', function () {
	$account = Account::factory()->create();
	$owner = User::factory()->for($account)->create();
	$position = Position::factory()->for($owner)->create();

	$foreignAccount = Account::factory()->create();
	$user = User::factory()->for($foreignAccount)->create();
	$admin = User::factory()->admin()->for($foreignAccount)->create();

	$response = $this
		->actingAs($user)
		->post("/positions/edit/$position->id", [
			'completed_at' => '2025-01-05',
			'hours' => 5.5,
			'category_id' => 1,
			'description' => 'Lorem Ipsum',
		]);
	$response->assertRedirect('/');
	expect(Position::find($position->id)->hours)->toBe($position->hours);

	$response = $this
		->actingAs($admin)
		->post("/positions/edit/$position->id", [
			'completed_at' => '2025-01-05',
			'hours' => 5.5,
			'category_id' => 1,
			'description' => 'Lorem Ipsum',
		]);
	expect(Position::find($position->id)->hours)->toBe(5.5);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/positions/add');
});


test('required parameters are missing', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();
	$position = Position::factory()->for($user)->create();

	$response = $this
		->actingAs($user)
		->post("/positions/edit/$position->id", [
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
