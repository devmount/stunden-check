<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('email verification screen can be rendered', function () {
	$account = Account::factory()->create();
	$user = User::factory()->unverified()->for($account)->create();

	$response = $this->actingAs($user)->get('/verify-email');

	$response->assertStatus(200);
});

test('email can be verified', function () {
	$account = Account::factory()->create();
	$user = User::factory()->unverified()->for($account)->create();

	Event::fake();

	$verificationUrl = URL::temporarySignedRoute(
		'verification.verify',
		now()->addMinutes(60),
		['id' => $user->id, 'hash' => sha1($user->email)]
	);

	$response = $this->actingAs($user)->get($verificationUrl);

	Event::assertDispatched(Verified::class);
	expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
	$response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function () {
	$account = Account::factory()->create();
	$user = User::factory()->unverified()->for($account)->create();

	$verificationUrl = URL::temporarySignedRoute(
		'verification.verify',
		now()->addMinutes(60),
		['id' => $user->id, 'hash' => sha1('wrong-email')]
	);

	$this->actingAs($user)->get($verificationUrl);

	expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('email verification notification can be sent', function () {
	$account = Account::factory()->create();
	$user = User::factory()->unverified()->for($account)->create();

	$response = $this->actingAs($user)->post('/email/verification-notification');

	$response->assertRedirect();
});
