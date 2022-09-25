<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Übersicht Stunden') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-4 grid-cols-3 justify-between">
			<div class="overflow-hidden shadow-md sm:rounded-lg p-6 text-center text-white bg-slate-600 border-4 border-white">
				Insgesamt
				<div class="text-6xl font-medium">35</div>
				Stunden geleistet
			</div>
			<div class="overflow-hidden shadow-md sm:rounded-lg p-6 text-center text-white bg-teal-600 border-4 border-white">
				Aktuelle Abrechnungsperiode
				<div class="text-6xl font-medium">11</div>
				Stunden geleistet
			</div>
			<div class="overflow-hidden shadow-md sm:rounded-lg p-6 text-center text-white bg-amber-600 border-4 border-white">
				Aktuelle Abrechnungsperiode
				<div class="text-6xl font-medium">13</div>
				Stunden ausstehend
			</div>
		</div>
	</div>

	<div class="pb-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 border-b border-gray-200">
				<div class="px-6 pb-4 flex justify-between items-center">
					<div>Geleistete Stunden</div>
					{{-- dialog to add new position --}}
					<x-modal class="max-w-lg">
						<x-slot name="trigger">
							<x-primary-button class="transition duration-150 ease-in-out">
								<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-2 text-white" viewBox="0 0 24 24">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
									<line x1="12" y1="5" x2="12" y2="19" />
									<line x1="5" y1="12" x2="19" y2="12" />
								</svg>
								{{ __('Neuer Eintrag') }}
							</x-primary-button>
						</x-slot>

						<x-slot name="title">
							Stunden schreiben
						</x-slot>

						<div class="mb-4">Gib hier an, wie lang und was du gearbeitet hast.</div>

						<form id="new-position-form" method="POST" action="{{ route('dashboard') }}">
							@csrf
							<!-- date (no time needed) -->
							<x-text-input
								id="date"
								class="block w-full"
								type="date"
								name="date"
								:label="__('Datum')"
								:value="old('date')"
								required
								autofocus
							/>
							<!-- hours -->
							<x-text-input
								id="hours"
								class="block mt-4 w-full"
								type="number"
								name="hours"
								:label="__('Stundenanzahl')"
								:value="old('hours')"
								required
							/>
							<!-- description -->
							<x-text-input
								id="description"
								class="block mt-4 w-full"
								type="text"
								name="description"
								:label="__('Beschreibung der Tätigkeit')"
								:value="old('description')"
								required
							/>
						</form>

						<x-slot name="action">
							<x-primary-button onclick="event.preventDefault();document.getElementById('new-position-form').submit();">
								{{ __('Speichern') }}
							</x-primary-button>
						</x-slot>
					</x-modal>
				</div>
				<table class="items-center bg-transparent w-full border-collapse">
					<thead>
						<tr>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								Beschreibung
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								Datum
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								Anzahl Stunden
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
							</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
							Rasen gemäht auf gesamten Kita-Gelände
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap">
							22. August 2022
						</td>
						<td class="px-6 py-4 align-center whitespace-nowrap">
							4
						</td>
						<td>
							<div class="flex flex-row">
								{{-- dialog to edit existing position --}}
								<x-modal class="max-w-lg">
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
										<x-text-input
											id="date"
											class="block w-full"
											type="date"
											name="date"
											:label="__('Datum')"
											:value="old('date')"
											required
											autofocus
										/>
										<!-- hours -->
										<x-text-input
											id="hours"
											class="block mt-4 w-full"
											type="number"
											name="hours"
											:label="__('Stundenanzahl')"
											:value="old('hours')"
											required
										/>
										<!-- description -->
										<x-text-input
											id="description"
											class="block mt-4 w-full"
											type="text"
											name="description"
											:label="__('Beschreibung der Tätigkeit')"
											:value="old('description')"
											required
										/>
									</form>

									<x-slot name="action">
										<x-primary-button onclick="event.preventDefault();document.getElementById('new-position-form').submit();">
											{{ __('Speichern') }}
										</x-primary-button>
									</x-slot>
								</x-modal>

								{{-- dialog to delete existing position --}}
								<x-modal class="max-w-lg">
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
							Klo geputzt im Fachwerkhaus
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap">
							25. August 2022
						</td>
						<td class="px-6 py-4 align-center whitespace-nowrap">
							2
						</td>
						<td></td>
					</tr>
					<tr>
						<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
							Holztor repariert
						</td>
						<td class="px-6 py-4 align-middle whitespace-nowrap">
							26. August 2022
						</td>
						<td class="px-6 py-4 align-center whitespace-nowrap">
							2
						</td>
						<td></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</x-app-layout>
