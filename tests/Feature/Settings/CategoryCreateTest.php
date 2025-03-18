<?php

use App\Models\Account;
use App\Models\Category;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('category create page can be rendered for admins', function () {
	$account = Account::factory()->create();
	$user = User::factory()->admin()->for($account)->create();

	$response = $this->actingAs($user)->get('/settings/cat/add');

	$response->assertOk();
});


test('category create page is forbidden for non-admins', function () {
	$account = Account::factory()->create();
	$user = User::factory()->for($account)->create();

	$response = $this->actingAs($user)->get('/settings/cat/add');

	$response->assertRedirect('/');
});


test('category can be added', function () {
	$account = Account::factory()->create();
	$user = User::factory()->admin()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/settings/cat/add', [
			'title' => 'New Cat',
			'description' => 'Lorem Ipsum',
		]);

	$response
		->assertSessionHasNoErrors()
		->assertRedirect('/settings?view=cat');

	$category = Category::where('title', '=', 'New Cat')->first();
	expect($category->description)->toBe('Lorem Ipsum');
	expect($category->positions->count())->toBe(0);
});


test('required parameters are missing', function () {
	$account = Account::factory()->create();
	$user = User::factory()->admin()->for($account)->create();

	$response = $this
		->actingAs($user)
		->post('/settings/cat/add', [
			'title' => null,
			'description' => null,
		]);

	$response
		->assertSessionHasErrors('title')
		->assertSessionHasErrors('description')
		->assertRedirect('/');

});
