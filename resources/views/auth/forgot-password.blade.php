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

		<div class="mb-4 text-sm">
			{{ __('Du hast dein Passwort vergessen? Kein Problem. Gib deine registrierte E-Mail-Adresse an und du bekommst eine E-Mail die einen Link zum zurücksetzen deines Passwortes enthält.') }}
		</div>

		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('password.email') }}">
			@csrf

			<!-- Email Address -->
			<x-text-input
				id="email"
				class="block mt-1 w-full"
				type="email"
				name="email"
				:label="__('E-Mail-Adresse')"
				:value="old('email')"
				required
				autofocus
			/>

			<div class="flex items-center justify-end mt-4">
				<x-primary-button>
					{{ __('Passwort-Zurücksetzen Link zusenden') }}
				</x-primary-button>
			</div>
		</form>

		<x-slot name="credits">
			@include('layouts.credits')
		</x-slot>
	</x-auth-card>
</x-guest-layout>
