<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration is deactivated', function () {
	$response = $this->get('/register');

	$response->assertStatus(404);
});

test('new users cannot register', function () {
	$response = $this->post('/register', [
		'name' => 'Test User',
		'email' => 'test@example.com',
		'password' => 'password',
		'password_confirmation' => 'password',
	]);

	$response->assertStatus(404);
});
