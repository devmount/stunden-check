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
					<x-modal class="max-w-3xl">
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
							Konto und Personen anlegen
						</x-slot>

						<div class="mb-4">
							Erstelle hier ein neues Konto mit einem oder zwei zugehörigen Personen.
						</div>

						<form id="new-account-form" method="POST" action="{{ route('dashboard') }}">
							@csrf

							<div class="flex gap-4">
								<!-- active -->
								<x-checkbox-input
									for="active"
									:label="__('Aktiv')"
									class="w-1/2"
								/>
								<!-- separateAccounting -->
								<x-checkbox-input
									for="separateAccounting"
									:label="__('Getrennte Abrechnung')"
									class="w-1/2"
								/>
							</div>

							<div class="flex gap-4 mt-4">
								<!-- date (no time needed) -->
								<x-text-input
									class="block w-1/2"
									type="date"
									name="start"
									:value="old('start')"
									:label="__('Datum Einstieg')"
									required
								/>
								<!-- hours -->
								<x-text-input
									class="block w-1/2"
									type="number"
									name="targetHours"
									:value="old('targetHours')"
									:label="__('Abweichende Mindestanzahl Pflichtstunden')"
									required
								/>
							</div>

							<div class="mt-4 flex gap-4">
								<!-- first person -->
								<div class="w-1/2">
									<h3>1. Person</h3>
									<!-- 1. firstname -->
									<x-text-input
										class="mt-4 block w-full"
										type="text"
										name="firstname1"
										:value="old('firstname1')"
										:label="__('Vorname')"
										required
									/>
									<!-- 1. lastname -->
									<x-text-input
										class="mt-4 block w-full"
										type="text"
										name="lastname1"
										:value="old('lastname1')"
										:label="__('Nachname')"
										required
									/>
									<!-- 1. email -->
									<x-text-input
										class="mt-4 block w-full"
										type="email"
										name="email1"
										:value="old('email1')"
										:label="__('E-Mail-Adresse')"
										required
									/>
									<!-- 1. isAdmin -->
									<x-checkbox-input
										for="isAdmin1"
										:label="__('Administrator')"
										class="mt-4"
									/>
								</div>
	
								<!-- second person -->
								<div class="w-1/2">
									<h3>2. Person</h3>
									<!-- 2. firstname -->
									<x-text-input
										class="mt-4 block w-full"
										type="text"
										name="firstname2"
										:value="old('firstname1')"
										:label="__('Vorname')"
										required
									/>
									<!-- 2. lastname -->
									<x-text-input
										class="mt-4 block w-full"
										type="text"
										name="lastname2"
										:value="old('lastname1')"
										:label="__('Nachname')"
										required
									/>
									<!-- 2. email -->
									<x-text-input
										class="mt-4 block w-full"
										type="email"
										name="email2"
										:value="old('email1')"
										:label="__('E-Mail-Adresse')"
										required
									/>
									<!-- 2. isAdmin -->
									<x-checkbox-input
										for="isAdmin2"
										:label="__('Administrator')"
										class="mt-4"
									/>								</div>
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
								{{-- dialog to edit existing account --}}
								<x-modal class="max-w-3xl">
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
										Konto und Personen bearbeiten
									</x-slot>

									<div class="mb-4">Nimm hier Änderungen am Konto und den zugeordneten Personen vor.</div>

									<form id="new-account-form" method="POST" action="{{ route('dashboard') }}">
										@csrf

										TODO
									</form>

									<x-slot name="action">
										<x-primary-button onclick="event.preventDefault();document.getElementById('new-account-form').submit();">
											{{ __('Speichern') }}
										</x-primary-button>
									</x-slot>
								</x-modal>

								{{-- dialog to delete existing account --}}
								<x-modal class="max-w-lg">
									<x-slot name="trigger">
										<button class="transition duration-150 ease-in-out">
											<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-red-600 hover:stroke-red-500 stroke-2" viewBox="0 0 24 24">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
												<rect x="3" y="4" width="18" height="4" rx="2" />
												<path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" />
												<line x1="10" y1="12" x2="14" y2="12" />
											</svg>
										</button>
									</x-slot>

									<x-slot name="title">
										Konto archivieren
									</x-slot>

									<div class="mb-4">Möchtest du dieses Konto wirklich deaktivieren? Es kann danach noch im Archiv eingesehen werden.</div>

									<x-slot name="action">
										<x-danger-button>
											{{ __('Archivieren') }}
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
