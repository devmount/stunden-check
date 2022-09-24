<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Übersicht Konten') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 border-b border-gray-200">
				<div class="px-6 pb-4 flex justify-between items-center">
					<div>Aktive Konten</div>
					{{-- dialog to add new account --}}
					<x-modal>
						<x-slot name="trigger">
							<x-primary-button class="transition duration-150 ease-in-out">
								<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-2 text-white" viewBox="0 0 24 24">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
									<line x1="12" y1="5" x2="12" y2="19" />
									<line x1="5" y1="12" x2="19" y2="12" />
								</svg>
								{{ __('Neues Konto') }}
							</x-primary-button>
						</x-slot>

						<x-slot name="title">
							Neues Konto anlegen
						</x-slot>

						<div class="mb-4">Erstelle hier ein neues Konto mit einem oder zwei Benutzern.</div>

						<form id="new-account-form" method="POST" action="{{ route('dashboard') }}">
							@csrf

							<!-- active -->
							<div>
								<x-checkbox-input for="active" :label="__('Aktiv')" class="text-sm" />
							</div>

							<!-- date (no time needed) -->
							<div class="mt-4">
								<x-input-label for="start" :value="__('Datum Einstieg')" />
								<x-text-input id="start" class="block mt-1 w-full" type="date" name="start" :value="old('start')" required autofocus />
							</div>

							<!-- hours -->
							<div class="mt-4">
								<x-input-label for="targetHours" :value="__('Mindestanzahl Pflichtstunden pro Abrechnungsperiode')" />
								<x-text-input id="targetHours" class="block mt-1 w-full" type="number" name="targetHours" :value="old('targetHours')" required autofocus />
							</div>

							<!-- separateAccounting -->
							<div class="mt-4">
								<x-checkbox-input for="separateAccounting" :label="__('Getrennte Abrechnung')" class="text-sm" />
							</div>
						</form>

						<x-slot name="action">
							<x-primary-button onclick="event.preventDefault();document.getElementById('new-account-form').submit();">
								{{ __('Speichern') }}
							</x-primary-button>
						</x-slot>
					</x-modal>
				</div>
				<table class="items-center bg-transparent w-full border-collapse">
					<thead>
						<tr>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								&num;
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								Personen
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								Eingestiegen am
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								Befreit am
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
							</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
							1
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
							<div class="flex flex-row gap-4">
								<div class="flex flex-row">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-1" viewBox="0 0 24 24">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
										<circle cx="12" cy="7" r="4" />
										<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
									</svg>
									Esther Müller
								</div>
								<div class="flex flex-row">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-1" viewBox="0 0 24 24">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
										<circle cx="12" cy="7" r="4" />
										<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
									</svg>
									Andreas Müller
								</div>
							</div>
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap">
							22. August 2022
						</td>
						<td class="px-6 py-4 align-center whitespace-nowrap">
							&mdash;
						</td>
						<td>
							<div class="flex flex-row">
								{{-- dialog to edit existing position --}}
								<x-modal>
									<x-slot name="trigger">
										<button class="transition duration-150 ease-in-out">
											<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-teal-600 hover:stroke-teal-500 stroke-2" viewBox="0 0 24 24">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
												<path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
												<path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
												<line x1="16" y1="5" x2="19" y2="8" />
											</svg>
										</button>
									</x-slot>

									<x-slot name="title">
										Eintrag bearbeiten
									</x-slot>

									<div class="mb-4">Gib hier an, wie lang und was du gearbeitet hast.</div>

									<form id="new-position-form" method="POST" action="{{ route('dashboard') }}">
										@csrf

										<!-- date (no time needed) -->
										<div>
											<x-input-label for="date" :value="__('Datum')" />
											<x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required autofocus />
										</div>

										<!-- hours -->
										<div class="mt-4">
											<x-input-label for="hours" :value="__('Stundenanzahl')" />
											<x-text-input id="hours" class="block mt-1 w-full" type="number" name="hours" :value="old('hours')" required autofocus />
										</div>

										<!-- description -->
										<div class="mt-4">
											<x-input-label for="description" :value="__('Beschreibung der Tätigkeit')" />
											<x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus />
										</div>
									</form>

									<x-slot name="action">
										<x-primary-button onclick="event.preventDefault();document.getElementById('new-position-form').submit();">
											{{ __('Speichern') }}
										</x-primary-button>
									</x-slot>
								</x-modal>

								{{-- dialog to delete existing position --}}
								<x-modal>
									<x-slot name="trigger">
										<button class="transition duration-150 ease-in-out">
											<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-red-600 hover:stroke-red-500 stroke-2" viewBox="0 0 24 24">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
												<line x1="4" y1="7" x2="20" y2="7" />
												<line x1="10" y1="11" x2="10" y2="17" />
												<line x1="14" y1="11" x2="14" y2="17" />
												<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
												<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
											</svg>
										</button>
									</x-slot>

									<x-slot name="title">
										Eintrag Löschen
									</x-slot>

									<div class="mb-4">Möchtest du diesen Eintrag wirklich löschen?</div>

									<x-slot name="action">
										<x-danger-button>
											{{ __('Löschen') }}
										</x-danger-button>
									</x-slot>
								</x-modal>
							</div>
						</td>
					</tr>
					<tr>
						<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
							2
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
							<div class="flex flex-row gap-4">
								<div class="flex flex-row">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-1" viewBox="0 0 24 24">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
										<circle cx="12" cy="7" r="4" />
										<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
									</svg>
									Torsten Musterman
								</div>
								<div class="flex flex-row">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-1" viewBox="0 0 24 24">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
										<circle cx="12" cy="7" r="4" />
										<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
									</svg>
									Tina Tango
								</div>
							</div>
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap">
							11. Mai 2022
						</td>
						<td class="px-6 py-4 align-center whitespace-nowrap">
							20.08. - 21.09.2022
						</td>
						<td></td>
					</tr>
					<tr>
						<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
							3
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
							<div class="flex flex-row gap-4">
								<div class="flex flex-row">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-1" viewBox="0 0 24 24">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
										<circle cx="12" cy="7" r="4" />
										<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
									</svg>
									Mina Master
								</div>
							</div>
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap">
							26. August 2022
						</td>
						<td class="px-6 py-4 align-center whitespace-nowrap">
							&mdash;
						</td>
						<td></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</x-app-layout>
