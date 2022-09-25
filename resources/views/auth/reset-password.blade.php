<x-guest-layout>
	<x-auth-card>
		<x-slot name="logo">
			<a href="/" class="flex items-center">
				<x-application-logo class="w-14 h-14 sm:w-20 sm:h-20 fill-transparent stroke-current stroke-1 text-teal-600" />
				<span class="text-teal-600 text-3xl sm:text-5xl">
					{{ config('app.name', 'StundenCheck') }}
				</span>
			</a>
		</x-slot>

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('password.update') }}">
			@csrf

			<!-- Password Reset Token -->
			<input type="hidden" name="token" value="{{ $request->route('token') }}">

			<!-- Email Address -->
			<x-text-input
				class="block w-full"
				type="email"
				name="email"
				:label="__('E-Mail-Adresse')"
				:value="old('email', $request->email)"
				required
				autofocus
			/>

			<!-- Password -->
			<x-text-input
				class="block mt-4 w-full"
				type="password"
				name="password"
				:label="__('Passwort')"
				required
			/>

			<!-- Confirm Password -->
			<x-text-input
				class="block mt-4 w-full"
				type="password"
				name="password_confirmation"
				:label="__('Passwort bestätigen')"
				required
			/>

			<div class="flex items-center justify-end mt-4">
				<x-primary-button>
					{{ __('Passwort zurücksetzen') }}
				</x-primary-button>
			</div>
		</form>

		<x-slot name="credits">
			@include('layouts.credits')
		</x-slot>
	</x-auth-card>
</x-guest-layout>
