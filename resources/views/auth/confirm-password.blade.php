<x-guest-layout>
	<x-auth-card>
		<x-slot name="logo">
			<a href="/" class="flex items-center">
				<x-application-logo class="w-14 h-14 sm:w-20 sm:h-20 fill-transparent stroke-current stroke-1 text-teal-600" />
				<span class="text-teal-600 text-3xl sm:text-5xl">{{ config('app.name', 'StundenCheck') }}</span>
			</a>
		</x-slot>

		<div class="mb-4 text-sm text-gray-600">
			{{ __('Das ist ein geschützter Bereich. Zum Fortfahren bitte bestätige mit deinem Passwort.') }}
		</div>

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('password.confirm') }}">
			@csrf

			<!-- Password -->
			<x-text-input
				id="password"
				class="block w-full"
				type="password"
				name="password"
				:label="__('Passwort')"
				required
			/>

			<div class="flex justify-end mt-4">
				<x-primary-button>
					{{ __('Bestätigen') }}
				</x-primary-button>
			</div>
		</form>

		<x-slot name="credits">
			@include('layouts.credits')
		</x-slot>
	</x-auth-card>
</x-guest-layout>
