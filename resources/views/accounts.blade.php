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
					<div>{{ __('Aktive Konten') }}</div>
					{{-- dialog to add new account --}}
					<x-primary-button onclick="window.location='{{ route('accounts-add') }}'" class="transition duration-150 ease-in-out">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-2 text-white" viewBox="0 0 24 24">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							<line x1="12" y1="5" x2="12" y2="19" />
							<line x1="5" y1="12" x2="19" y2="12" />
						</svg>
						{{ __('Neues Konto') }}
					</x-primary-button>
				</div>
				<table class="items-center bg-transparent w-full border-collapse">
					<thead>
						<tr>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								&num;
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								{{ __('Personen') }}
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								{{ __('Eingestiegen am') }}
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
								{{ __('Befreit am') }}
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($accounts as $account)
						<tr>
							<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
								{{ $account->id }}
							</td>
							<td class="px-6 py-4 align-middle whitespace-nowrap text-left">
								<div class="flex flex-row gap-4">
								@foreach ($account->users as $user)
									<div class="flex flex-row" title="{{ $user->is_admin ? 'Administrator' : '' }}">
										<svg
											xmlns="http://www.w3.org/2000/svg"
											class="w-6 h-6 mr-2 fill-transparent {{ $user->is_admin ? 'stroke-teal-600 fill-teal-600' : 'stroke-current' }} stroke-1"
											viewBox="0 0 24 24"
										>
											<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
											<circle cx="12" cy="7" r="4" />
											<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
										</svg>
										{{ $user->firstname }} {{ $user->lastname }}
									</div>
								@endforeach
								</div>
							</td>
							<td class="px-6 py-4 align-middle whitespace-nowrap">
								{{ $account->start }}
							</td>
							<td class="px-6 py-4 align-center whitespace-nowrap">
								&mdash;
							</td>
							<td>
								<div class="flex flex-row">
									{{-- link to edit existing account --}}
									<button onclick="window.location='{{ route('accounts-edit', $account->id) }}'" class="transition duration-150 ease-in-out">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-teal-600 hover:stroke-teal-500 stroke-2" viewBox="0 0 24 24">
											<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
											<path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
											<path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
											<line x1="16" y1="5" x2="19" y2="8" />
										</svg>
									</button>

									{{-- dialog to archive existing account --}}
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
											{{ __('Konto archivieren') }}
										</x-slot>

										<div class="mb-4">
											{{ __('Möchtest du dieses Konto wirklich deaktivieren? Es kann danach noch im Archiv eingesehen werden.') }}
										</div>

										<x-slot name="action">
											<form method="POST" action="{{ route('accounts-archive', $account->id) }}">
												@csrf
												<x-danger-button>
													{{ __('Archivieren') }}
												</x-danger-button>
											</form>
										</x-slot>
									</x-modal>
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	@if (session('status'))
		<x-toast>{{ session('status') }}</x-toast>
	@endif
</x-app-layout>
