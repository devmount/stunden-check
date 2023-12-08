<x-app-layout>
	<x-slot name="header">
		<h2>
			<a href="{{ route('accounts') }}" class="transition text-teal-600 hover:text-teal-400">
				{{ __('Übersicht Konten') }}
			</a>
			/ {{ isset($account) ? __('Konto und Personen bearbeiten') : __('Konto und Personen anlegen') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-content-card class="p-6">

				@if (isset($account))
					<div class="mb-8">
						{{ __('Passe hier die Daten des Kontos und der zugehörigen Personen an.') }}
					</div>
				@else
					<div class="mb-2">
						{{ __('Erstelle hier ein neues Konto mit einem oder zwei zugehörigen Personen.') }}
					</div>
					<div class="mb-8 border-l-4 p-4 text-amber-900 dark:text-amber-100 bg-amber-50 dark:bg-amber-900/25 border-amber-200 dark:border-amber-800">
						{{ __('Beim Klick auf Speichern wird den angegebenen Personen per E-Mail ein initiales Password geschickt.') }}
					</div>
				@endif

				<form method="POST" action="{{ isset($account) ? route('accounts-edit', $account->id) : route('accounts-add') }}">
					@csrf
					@include('forms.account-formfields')

					<div class="flex justify-end gap-2 mt-4">
						<x-secondary-button onclick="event.preventDefault();window.location='{{ route('accounts') }}'">
							{{ __('Abbrechen') }}
						</x-secondary-button>
						<x-primary-button>
							{{ __('Speichern') }}
						</x-primary-button>
					</div>
				</form>

			</x-content-card>
		</div>
	</div>
</x-app-layout>
