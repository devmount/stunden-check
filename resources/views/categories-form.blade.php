<x-app-layout>
	<x-slot name="header">
		<h2>
			<a href="{{ route('settings', ['view' => 'cat']) }}" class="transition text-teal-600 hover:text-teal-400">
				{{ __('Einstellungen') }}
			</a>
			/ {{ isset($category) ? __('Bereich bearbeiten') : __('Bereich erstellen') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-content-card class="p-6">

				<div class="mb-4">
					{{ __('Bennene hier den Tätigkeitsbereich. Eine kurze, aussagekräftige Beschreibung ist sinnvoll.') }}
				</div>

				<form method="POST" action="{{ isset($category) ? route('categories-edit', $category->id) : route('categories-add') }}">
					@csrf
					@include('forms.category-formfields')

					<div class="flex flex-col-reverse sm:flex-row items-end justify-end gap-2 mt-4">
						<x-secondary-button onclick="event.preventDefault();window.location='{{ route('settings', ['view' => 'cat']) }}'">
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
