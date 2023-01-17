<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			<a href="{{ route('accounts') }}" class="transition text-teal-600 hover:text-teal-400">
				{{ __('Übersicht Konten') }}
			</a>
			/ {{ __('Einträge ansehen') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pb-6 border-b border-gray-200">

				{{-- iterate over users assignet to account --}}
				@foreach ($account->users as $user)
					<div class="px-6 pb-4 mt-12 flex justify-between items-center">
						<div class="flex flex-col sm:flex-row sm:gap-4">
							<span class="font-semibold">{{ $user->firstname }} {{ $user->lastname }}</span>
							@if ($user->positions->count() > 1)
								<span class="text-gray-600">{{ $user->positions->count() }} {{ __('Einträge') }}</span>
							@endif
						</div>
					</div>
					<table class="items-center bg-transparent w-full border-collapse">
						<thead>
							<tr>
								<th class="px-3 md:px-6 py-3 bg-slate-50 text-slate-500 align-middle truncate border border-solid border-slate-200 uppercase border-l-0 border-r-0 font-semibold text-left">
									{{ __('Beschreibung') }}
								</th>
								<th class="w-20 md:w-auto px-3 md:px-6 py-3 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 uppercase border-l-0 border-r-0 font-semibold text-left">
									{{ __('Datum') }}
								</th>
								<th class="hidden xl:table-cell px-3 md:px-6 py-3 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 uppercase border-l-0 border-r-0 font-semibold text-left">
									{{ __('Tätigkeitsbereich') }}
								</th>	
								<th class="w-16 md:w-auto px-3 md:px-6 py-3 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 uppercase border-l-0 border-r-0 font-semibold text-center">
									<span class="xl:hidden">{{ __('Std.') }}</span>
									<span class="hidden xl:inline">{{ __('Anzahl Stunden') }}</span>
								</th>
							</tr>
						</thead>
						<tbody>
						@forelse ($user->positions->sortByDesc('completed_at') as $position)
							<tr class="even:bg-slate-50 hover:bg-slate-200">
								<td class="px-3 md:px-6 py-3 md:py-4 align-middle text-left max-w-[100px] md:max-w-md lg:max-w-xl truncate">
									{{ $position->description }}
								</td>
								<td class="px-3 md:px-6 py-3 md:py-4 align-middle whitespace-nowrap">
									<span class="lg:hidden">{{ shortdate($position->completed_at) }}</span>
									<span class="hidden lg:inline">{{ hdate($position->completed_at) }}</span>
								</td>
								<td class="hidden xl:table-cell px-3 md:px-6 py-3 md:py-4 align-middle text-left">
									{{ $position->category->title }}
								</td>	
								<td class="px-3 md:px-6 py-3 md:py-4 align-middle text-center">
									{{ $position->hours }}
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4">
									<div class="mb-4 border-l-4 p-4 text-amber-900 bg-amber-50 border-amber-200">
										{{ __('Hier sind noch keine Einträge vorhanden.') }}
									</div>
								</td>
							</tr>
						@endforelse
						</tbody>
					</table>
				@endforeach

			</div>
		</div>
	</div>
</x-app-layout>
