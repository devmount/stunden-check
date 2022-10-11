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
				<div class="text-6xl font-medium">{{ $user->sum_hours }}</div>
				Stunden geleistet
			</div>
			<div class="
				overflow-hidden shadow-md sm:rounded-lg p-6 text-center text-white border-4 border-white
				@if ($user->missing_hours > 0) bg-amber-600 @else bg-slate-600 @endif
			">
				Insgesamt
				<div class="text-6xl font-medium">{{ $user->missing_hours >= 0 ? $user->missing_hours : 0 }}</div>
				Stunden ausstehend
			</div>
			<div class="overflow-hidden shadow-md sm:rounded-lg p-6 text-center text-white bg-teal-600 border-4 border-white">
				Aktuelle Abrechnungsperiode
				<div class="text-6xl font-medium">{{ $user->cycle_hours }} / {{ $user->account->target_hours }}</div>
				Stunden geleistet
			</div>
		</div>
	</div>

	<div class="pb-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 border-b border-gray-200">
				<div class="px-6 pb-4 flex justify-between items-center">
					<div>Geleistete Stunden</div>
					{{-- dialog to add new position --}}
					<x-primary-button onclick="window.location='{{ route('positions-add') }}'" class="transition duration-150 ease-in-out">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-2 text-white" viewBox="0 0 24 24">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							<line x1="12" y1="5" x2="12" y2="19" />
							<line x1="5" y1="12" x2="19" y2="12" />
						</svg>
						{{ __('Neuer Eintrag') }}
					</x-primary-button>
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
					@forelse ($user->positions as $i => $position)
						<tr>
							<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
								{{ $position->description }}
							</td>
							<td class="px-6 py-4 align-middle whitespace-nowrap">
								{{ hdate($position->completed_at) }}
							</td>
							<td class="px-6 py-4 align-center whitespace-nowrap">
								{{ $position->hours }}
							</td>
							<td>
								<div class="flex flex-row">
									{{-- dialog to edit existing position --}}
									<button onclick="window.location='{{ route('positions-edit', $position->id) }}'" class="transition duration-150 ease-in-out">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-teal-600 hover:stroke-teal-500 stroke-2" viewBox="0 0 24 24">
											<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
											<path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
											<path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
											<line x1="16" y1="5" x2="19" y2="8" />
										</svg>
									</button>

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
											<form method="POST" action="{{ route('positions-delete', $position->id) }}">
												@csrf
												<x-danger-button>
													{{ __('Löschen') }}
												</x-danger-button>
											</form>
										</x-slot>
									</x-modal>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="4">
								<div class="mb-4 border-l-4 p-4 text-amber-900 bg-amber-50 border-amber-200">
									{{-- <div class="font-bold">{{ __('Achtung!') }}</div> --}}
									{{ __('Es sind noch keine Einträge vorhanden.') }}
								</div>
							</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</x-app-layout>
