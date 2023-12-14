<x-app-layout>
	<x-slot name="header">
		<h2 class="flex flex-col sm:flex-row gap-6 justify-between items-center">
			<div>{{ __('Übersicht Stunden') }}</div>
			<x-select-input :label="false" class="-my-2" get-nav>
				@foreach (App\Models\Parameter::cycles(true) as $key => $date)
					<option value="{{ $date->format('Y-m-d') }}" @selected($date == $selectedStart)>
						{{ __('Ab') }} {{ $date->isoFormat('LL') }}
					</option>
				@endforeach
			</x-select-input>
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 grid gap-4 grid-cols-1 md:grid-cols-3 justify-between">
			<div class="
				md:flex flex-col items-center shadow-md rounded md:rounded-lg p-2 md:p-6 text-center
				text-white bg-slate-600 md:border-4 border-white dark:border-slate-500
			">
				{{ __('Insgesamt') }}
				<br class="md:hidden" />
				<span class="text-xl md:text-3xl lg:text-6xl font-bold md:font-medium">
					{{ $total_sum }} / {{ $total_target }}
				</span>
				{{ __('Stunden geleistet') }}
			</div>
			<div class="
				md:flex flex-col items-center shadow-md rounded md:rounded-lg p-2 md:p-6 text-center
				text-white bg-teal-600 md:border-4 border-white dark:border-teal-500
			">
				{{ $selectedStart->isoFormat('ll') }} &mdash; {{ $selectedEnd->isoFormat('ll') }}
				<br class="md:hidden" />
				<span class="text-xl md:text-3xl lg:text-6xl font-bold md:font-medium">
					{{ $cycle_sum }} / {{ $cycle_target }}
				</span>
				{{ __('Stunden geleistet') }}
			</div>
			<div class="
				md:flex flex-col items-center shadow-md rounded md:rounded-lg p-2 md:p-6 text-center
				text-white md:border-4 border-white dark:border-slate-500
				@if ($missing > 0) bg-amber-600 dark:border-amber-500 @else bg-slate-600 @endif
			">
				{{ $selectedStart->isoFormat('ll') }} &mdash; {{ $selectedEnd->isoFormat('ll') }}
				<br class="md:hidden" />
				<span class="text-xl md:text-3xl lg:text-6xl font-bold md:font-medium">
					{{ $missing }}
				</span>
				{{ __('Stunden ausstehend') }}
			</div>
		</div>
	</div>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-content-card>
				{{-- me --}}
				<div class="px-6 pb-4 flex justify-between items-center">
					<div class="flex flex-col sm:flex-row sm:gap-4">
						<span class="font-semibold">{{ __('Meine Stunden') }}</span>
						@if ($user_positions->count() > 1)
							<span class="text-gray-600 dark:text-gray-400">
								{{ $user_positions->count() }} {{ __('Einträge') }}
							</span>
						@endif
					</div>
					<x-primary-button onclick="window.location='{{ route('positions-add') }}'" add>
						{{ __('Neuer Eintrag') }}
					</x-primary-button>
				</div>
				<table>
					<thead>
						<tr>
							<th class="truncate text-left">
								{{ __('Beschreibung') }}
							</th>
							<th class="w-20 md:w-auto text-left">
								{{ __('Datum') }}
							</th>
							<th class="hidden xl:table-cell text-left">
								{{ __('Tätigkeitsbereich') }}
							</th>
							<th class="w-16 md:w-auto text-center">
								<span class="xl:hidden">{{ __('Std.') }}</span>
								<span class="hidden xl:inline">{{ __('Anzahl Stunden') }}</span>
							</th>
							<th class="w-20 text-left">
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($user_positions->sortByDesc('completed_at') as $position)
						<tr>
							<td class="text-left max-w-0 xs:max-w-md lg:max-w-xl">
								<div class="truncate" title="{{ $position->description }}">{{ $position->description }}</div>
							</td>
							<td class="whitespace-nowrap">
								<span class="lg:hidden">{{ shortdate($position->completed_at) }}</span>
								<span class="hidden lg:inline">{{ hdate($position->completed_at) }}</span>
							</td>
							<td class="hidden xl:table-cell text-left">
								{{ $position->category->title }}
							</td>
							<td class="text-center">
								{{ $position->hours }}
							</td>
							<td>
								<div class="flex gap-2">
									{{-- page to edit existing position --}}
									<x-text-button
										onclick="window.location='{{ route('positions-edit', $position->id) }}'"
										class="text-teal-600 hover:text-teal-500"
										title="{{ __('Bearbeiten') }}"
										edit
									/>

									{{-- dialog to delete existing position --}}
									<x-modal class="max-w-lg">
										<x-slot name="trigger">
											<x-text-button class="text-red-600 hover:text-red-500" title="{{ __('Löschen') }}" delete />
										</x-slot>

										<x-slot name="title">
											{{ __('Eintrag Löschen') }}
										</x-slot>

										<div class="mb-4">
											{{ __('Möchtest du diesen Eintrag wirklich löschen?') }}
										</div>

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
							<td colspan="5" class="p-8 text-center">
								{{ __('Hier sind noch keine Einträge vorhanden.') }}
							</td>
						</tr>
					@endforelse
					</tbody>
				</table>

				{{-- partner --}}
				@if ($partner)
					<div class="px-6 pb-4 mt-12 flex justify-between items-center">
						<div class="flex flex-col sm:flex-row sm:gap-4">
							<span class="font-semibold">{{ $partner->firstname }}'s {{ __('Stunden') }}</span>
							@if ($partner_positions->count() > 1)
								<span class="text-gray-600 dark:text-gray-400">
									{{ $partner_positions->count() }} {{ __('Einträge') }}
								</span>
							@endif
						</div>
					</div>
					<table>
						<thead>
							<tr>
								<th class="max-w-[100px] md:max-w-xl truncate text-left">
									{{ __('Beschreibung') }}
								</th>
								<th class="w-20 md:w-auto text-left">
									{{ __('Datum') }}
								</th>
								<th class="hidden xl:table-cell text-left">
									{{ __('Tätigkeitsbereich') }}
								</th>
								<th class="w-16 md:w-auto text-center">
									<span class="lg:hidden">{{ __('Std.') }}</span>
									<span class="hidden lg:inline">{{ __('Anzahl Stunden') }}</span>
								</th>
							</tr>
						</thead>
						<tbody>
						@forelse ($partner_positions->sortByDesc('completed_at') as $position)
							<tr>
								<td class="text-left max-w-0 xs:max-w-md lg:max-w-xl">
									<div class="truncate" title="{{ $position->description }}">{{ $position->description }}</div>
								</td>
								<td class="whitespace-nowrap">
									<span class="lg:hidden">{{ shortdate($position->completed_at) }}</span>
									<span class="hidden lg:inline">{{ hdate($position->completed_at) }}</span>
								</td>
								<td class="hidden xl:table-cell text-left">
									{{ $position->category->title }}
								</td>
								<td class="text-center">
									{{ $position->hours }}
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="p-8 text-center">
									{{ __('Hier sind noch keine Einträge vorhanden.') }}
								</td>
							</tr>
						@endforelse
						</tbody>
					</table>
				@endif

				</x-content-card>
		</div>
	</div>
</x-app-layout>
