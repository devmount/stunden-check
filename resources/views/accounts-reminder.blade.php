<x-app-layout>
	<x-slot name="header">
		<h2>
			<a href="{{ route('accounts') }}" class="transition text-teal-600 hover:text-teal-400">
				{{ __('Übersicht Konten') }}
			</a>
			/ {{ __('Erinnerungs-E-Mail für Konten') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-content-card class="p-6 flex flex-col gap-8">

				<div>
					{{ __('An alle Konten mit ausstehenden Stunden können hier Erinnerungs-E-Mails geschickt werden.') }}<br />
					@if ($executed)
						{{ __('Zuletzt wurde diese Funktion am ' . hdatetime($executed) . ' ausgeführt.') }}
					@else
						{{ __('Diese Funktion wurde bisher noch nie ausgeführt.') }}
					@endif
					{{ __('Aktuell gibt es ' . count($users) . ' Benutzer deren Konto ausstehende Stunden für den aktuellen Abrechnungszeitraum hat.') }}
				</div>

				<div class="flex flex-col gap-4">
					<div>{{ __('Vorschau des E-Mail Inhalts:') }}</div>
					<div class="mail-preview sm:w-2/3 font-mono text-xs bg-gray-100 dark:bg-gray-800/50 rounded-lg p-6">
						@include('mail.reminder-email', App\Mail\ReminderMail::demoData())
					</div>
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

			</x-content-card>
		</div>
	</div>
</x-app-layout>
