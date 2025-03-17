<?php

use App\Models\Account;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('category can be deleted', function () {
	$account = Account::factory()->create();
	$user = User::factory()->admin()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/settings/cat/delete/1', [
			'replacement' => 2,
		]);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/settings?view=cat');
});


test('required parameters are missing', function () {
	$account = Account::factory()->create();
	$user = User::factory()->admin()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/settings/cat/delete/1', [
			'replacement' => null,
		]);

	$response
		->assertSessionHasErrors('replacement')
		->assertRedirect('/');

});
