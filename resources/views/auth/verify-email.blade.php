<x-guest-layout>
	<x-auth-card>
		<x-slot name="logo">
			<a href="/" class="flex items-center">
				<x-application-logo class="w-14 h-14 sm:w-20 sm:h-20 fill-transparent stroke-current stroke-1 text-teal-600" />
				<span class="text-teal-600 text-3xl sm:text-5xl">{{ config('app.name', 'StundenCheck') }}</span>
			</a>
		</x-slot>

		<div class="mb-4 text-sm text-gray-600">
			{{ __('Danke für die Registrierung! Bevor es losgehen kann, verifiziere bitte deine E-Mail-Adresse in dem du auf den Link klickst, der dir soeben gesendet wurde. Falls die E-Mail nicht angekommen ist, senden wir dir gern einen neuen Link zu.') }}
		</div>

		@if (session('status') == 'verification-link-sent')
			<div class="mb-4 font-medium text-sm text-green-600">
				{{ __('Ein neuer Verifizierungslink wurde an die bei der Registrierung angegebenen E-Mail-Adresse versendet.') }}
			</div>
		@endif

		<div class="mt-4 flex items-center justify-between">
			<form method="POST" action="{{ route('verification.send') }}">
				@csrf
				<x-primary-button>
					{{ __('Link erneut versenden') }}
				</x-primary-button>
			</form>

			<form method="POST" action="{{ route('logout') }}">
				@csrf
				<button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
					{{ __('Abmelden') }}
				</button>
			</form>
		</div>

		<x-slot name="credits">
			@include('layouts.credits')
		</x-slot>
	</x-auth-card>
</x-guest-layout>
