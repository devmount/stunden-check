<x-app-layout>
	<x-slot name="header">
		<h2 class="flex flex-col sm:flex-row gap-6 justify-between items-center">
			<div>
				<a href="{{ route('accounts') }}?start={{ $selectedStart->format('Y-m-d') }}" class="transition text-teal-600 hover:text-teal-400">
					{{ __('Übersicht Konten') }}
				</a>
				/ {{ __('Einträge ansehen') }}
			</div>
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
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-content-card class="flex flex-col gap-12">

				{{-- iterate over users assignet to account --}}
				@foreach ($account->users as $user)
					<div>
						<div class="px-6 pb-4 flex justify-between items-center">
							<div class="flex flex-col sm:flex-row sm:gap-4">
								<span class="font-semibold">{{ $user->firstname }} {{ $user->lastname }}</span>
								@if ($user->positions()->byCycle($selectedStart)->count() > 1)
									<span class="text-gray-600">{{ $user->positions()->byCycle($selectedStart)->count() }} {{ __('Einträge') }}</span>
								@endif
							</div>
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
								</tr>
							</thead>
							<tbody>
							@forelse ($user->positions()->byCycle($selectedStart)->get()->sortByDesc('completed_at') as $position)
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
					</div>
				@endforeach

			</x-content-card>
		</div>
	</div>
</x-app-layout>
