<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Einstellungen') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">

				<div class="mb-4">
					{{ __('Passe hier die allgemeinen Einstellungen der Anwendung an.') }}
				</div>
				<div class="mb-4 border-l-4 p-4 text-amber-900 bg-amber-50 border-amber-200">
					<div class="font-bold">{{ __('Achtung!') }}</div>
					{{ __('Änderungen wirken sich auf die Stundenberechnung aller bestehender Konten aus.') }}
				</div>

				<form method="POST" action="{{ route('settings') }}">
					@csrf
					@include('forms.parameter-formfields')
					
					<div class="flex justify-end gap-2 mt-8">
						<x-secondary-button onclick="event.preventDefault();window.location='{{ route('settings') }}'">
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
	@if (session('status'))
		<x-toast>{{ session('status') }}</x-toast>
	@endif
</x-app-layout>
