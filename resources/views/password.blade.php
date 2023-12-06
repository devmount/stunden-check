<x-app-layout>
	<x-slot name="header">
		<h2>
			<a href="{{ route('profile') }}" class="transition text-teal-600 hover:text-teal-400">
				{{ __('Dein Profil') }}
			</a>
			/ {{ __('Passwort ändern') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">

				<div class="mb-4">
					{{ __('Ändere hier dein aktuelles Passwort.') }}
				</div>

				<form method="POST" action="{{ route('password.change') }}">
					@csrf
					@include('forms.password-formfields')

					<div class="flex justify-end gap-2 mt-4">
						<x-secondary-button onclick="event.preventDefault();window.location='{{ route('profile') }}'">
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
