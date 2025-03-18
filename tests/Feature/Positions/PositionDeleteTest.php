<?php

use App\Models\Account;
use App\Models\Position;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('position can be deleted by owner', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();
	$position = Position::factory()->for($user)->create();

	$response = $this
		->actingAs($user)
		->post("/positions/delete/$position->id");

	expect(Position::find($position->id))->toBeNull();

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/');
});


test('position can only be deleted by owner or admin', function () {
	$account = Account::factory()->create();
	$owner = User::factory()->for($account)->create();
	$position = Position::factory()->for($owner)->create();

	$foreignAccount = Account::factory()->create();
	$user = User::factory()->for($foreignAccount)->create();
	$admin = User::factory()->admin()->for($foreignAccount)->create();

	$response = $this
		->actingAs($user)
		->post("/positions/delete/$position->id");

	expect(Position::find($position->id)->id)->toBe($position->id);

	$response = $this
		->actingAs($admin)
		->post("/positions/delete/$position->id");

	expect(Position::find($position->id))->toBeNull();

	$response->assertRedirect('/');
});
