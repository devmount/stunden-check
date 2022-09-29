<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			<a href="{{ route('accounts') }}" class="transition text-teal-600 hover:text-teal-400">
				{{ __('Übersicht Konten') }}
			</a>
			/ {{ isset($account) ? __('Konto und Personen bearbeiten') : __('Konto und Personen anlegen') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">

				<div class="mb-4">
					{{ isset($accounts)
						? __('Erstelle hier ein neues Konto mit einem oder zwei zugehörigen Personen.')
						: __('Passe hier die Daten des Kontos und der zugehörigen Personen an.') }}
				</div>

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


			</div>
		</div>
	</div>
</x-app-layout>
