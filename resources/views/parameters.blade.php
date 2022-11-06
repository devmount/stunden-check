<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Einstellungen') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div
				class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 border-b border-gray-200"
				x-data="{
					tabs: ['param', 'email'],
					active: 'param',
				}"
			>
				<div class="px-6 pb-4 flex justify-between items-center">
					<div class="inline-flex bg-slate-100 rounded-lg gap-1 p-2">
						<button
							@click="active = 'param'"
							:class="[active === 'param' && 'bg-white text-black shadow', active !== 'param' && 'text-slate-600']"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							Anwendungs-Parameter
						</button>
						<button
							@click="active = 'email'"
							:class="[active === 'email' && 'bg-white text-black shadow', active !== 'email' && 'text-slate-600']"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							E-Mail Konfiguration
						</button>
					</div>
				</div>
				{{-- app parameter --}}
				<div x-show="active === 'param'" class="px-6">
					<div class="mb-4">
						{{ __('Passe hier die allgemeinen Einstellungen der Anwendung an.') }}
					</div>
					<div class="mb-4 border-l-4 p-4 text-amber-900 bg-amber-50 border-amber-200">
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
				{{-- email config --}}
				<div x-show="active === 'email'" class="px-6">
					<div class="mb-4">
						{{ __('Passe hier die E-Mail Einstellungen an und teste sie.') }}
					</div>
					<form method="POST" action="{{ route('testmail') }}">
						@csrf
						
						<div class="flex flex-col sm:flex-row gap-4 mt-8">
							<div class="sm:w-1/2">
								<x-text-input
									class="mt-4 block"
									type="email"
									name="testmail"
									:label="__('Test E-Mail-Adresse')"
									required
								/>
							</div>
							<div class="sm:w-1/2">
							</div>
						</div>
						<div class="mt-4">
							<x-primary-button>
								{{ __('Test E-Mail senden') }}
							</x-primary-button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
