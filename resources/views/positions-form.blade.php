<x-app-layout>
	<x-slot name="header">
		<h2>
			<a href="{{ route('dashboard') }}" class="transition text-teal-600 hover:text-teal-400">
				{{ __('Übersicht Stunden') }}
			</a>
			/ {{ isset($position) ? __('Eintrag bearbeiten') : __('Eintrag erstellen') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-content-card class="p-6">

				<div class="mb-4">
					{{ __('Gib hier an, wann du wieviele Stunden gearbeitet hast. Eine kurze, aussagekräftige Beschreibung deiner Tätigkeit ist sinnvoll.') }}
				</div>

				<form method="POST" action="{{ isset($position) ? route('positions-edit', $position->id) : route('positions-add') }}">
					@csrf
					@include('forms.position-formfields')

					<div class="flex flex-col-reverse sm:flex-row items-end justify-end gap-2 mt-4">
						<x-secondary-button onclick="event.preventDefault();window.location='{{ route('dashboard') }}'">
							{{ __('Abbrechen') }}
						</x-secondary-button>
						<x-primary-button name="go_back">
							{{ __('Speichern & Schließen') }}
						</x-primary-button>
						<x-primary-button name="go_next">
							{{ __('Speichern & Neu') }}
						</x-primary-button>
					</div>
				</form>

			</x-content-card>
		</div>
	</div>
</x-app-layout>
