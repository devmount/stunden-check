<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			<a href="{{ route('accounts') }}" class="transition text-teal-600 hover:text-teal-400">
				{{ __('Übersicht Konten') }}
			</a>
			/ {{ __('Erinnerungs-E-Mail für Konten') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">

				<div class="mb-8">
					{{ __('An alle Konten mit ausstehenden Stunden können hier Erinnerungs-E-Mails geschickt werden.') }}<br />
					@if ($executed)
						{{ __('Zuletzt wurde diese Funktion am ' . hdatetime($executed) . ' ausgeführt.') }}
					@else
						{{ __('Diese Funktion wurde bisher noch nie ausgeführt.') }}
					@endif
					{{ __('Aktuell gibt es ' . count($users) . ' Benutzer deren Konto ausstehende Stunden für den aktuellen Abrechnungszeitraum hat.') }}
				</div>

				<form method="POST" action="{{ route('accounts-reminder') }}">
					@csrf

					<div class="flex justify-end gap-2 mt-4">
						<x-secondary-button onclick="event.preventDefault();window.location='{{ route('accounts') }}'">
							{{ __('Abbrechen') }}
						</x-secondary-button>
						<x-primary-button>
							{{ __(count($users) . ' E-Mails senden') }}
						</x-primary-button>
					</div>
				</form>

			</div>
		</div>
	</div>
</x-app-layout>
