<x-guest-layout>
	<x-auth-card>
		<x-slot name="logo">
			<a href="/" class="flex items-center">
				<x-application-logo class="w-14 h-14 sm:w-20 sm:h-20 fill-transparent stroke-current stroke-1 text-teal-600" />
				<span class="text-teal-600 text-3xl sm:text-5xl">{{ config('app.name', 'StundenCheck') }}</span>
			</a>
		</x-slot>

		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('login') }}">
			@csrf
			<!-- Email Address -->
			<x-text-input
				class="block"
				type="email"
				name="email"
				:label="__('E-Mail-Adresse')"
				:value="old('email')"
				required
				autofocus
			/>
			<!-- Password -->
			<x-text-input
				class="block mt-4"
				type="password"
				name="password"
				:label="__('Passwort')"
				required
			/>
			<!-- Remember Me -->
			<x-checkbox-input
				for="remember"
				:label="__('Angemeldet bleiben')"
				class="block mt-4"
			/>

			<div class="flex items-center justify-end mt-4">
				@if (Route::has('password.request'))
					<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
						{{ __('Passwort vergessen?') }}
					</a>
				@endif

				<x-primary-button class="ml-3">
					{{ __('Anmelden') }}
				</x-primary-button>
			</div>
		</form>

		<x-slot name="credits">
			@include('layouts.credits')
		</x-slot>
	</x-auth-card>
</x-guest-layout>
