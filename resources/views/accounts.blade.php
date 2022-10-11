<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Übersicht Konten') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div
				class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 border-b border-gray-200"
				x-data="{
					tabs: ['active', 'archived'],
					active: 'active',
				}"
			>
				<div class="px-6 pb-4 flex justify-between items-center">
					<div class="inline-flex bg-slate-100 rounded-lg gap-1 p-2">
						<button
							@click="active = 'active'"
							:class="[active === 'active' && 'bg-white text-black shadow', active !== 'active' && 'text-slate-600']"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							Aktive Konten
							@if (count($activeAccounts) > 0)
								<span class="inline-block ml-3 font-bold">{{ count($activeAccounts) }}</span>
							@endif
						</button>
						<button
							@click="active = 'archived'"
							:class="[active === 'archived' && 'bg-white text-black shadow', active !== 'archived' && 'text-slate-600']"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							Archiv
							@if (count($archivedAccounts) > 0)
								<span class="inline-block ml-3 font-bold">{{ count($archivedAccounts) }}</span>
							@endif
						</button>
					</div>
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
				{{-- active accounts table --}}
				<table x-show="active === 'active'" class="items-center bg-transparent w-full border-collapse">
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
								{{ __('Status') }}
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($activeAccounts as $i => $account)
						<tr class="{{ $i%2 == 1 ? 'bg-slate-50' : ''}} hover:bg-slate-200">
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
								{{ hdate($account->start) }}
							</td>
							<td class="px-6 py-4 align-center whitespace-nowrap">
								@foreach ($account->excemptions as $ex)
									<div>{{ hdate($ex->start) }}&mdash;{{ hdate($ex->end) }}</div>
								@endforeach
							</td>
							<td class="px-6 py-4 align-middle whitespace-nowrap">
								@if ($account->separate_accounting)
									<div class="flex gap-4 items-center">
										@foreach ($account->users as $user)
											<div class="flex gap-2 items-center">
												<div class="w-2 h-2 rounded-full
													@switch($user->status)
														@case(0) bg-red-500   @break
														@case(1) bg-amber-500 @break
														@case(2) bg-teal-500  @break
														@default
													@endswitch
													"></div>
												<div>
													{{ $user->sum_hours }} / {{ $user->total_hours }}
												</div>
											</div>
										@endforeach
									</div>
								@else
									<div class="flex gap-2 items-center">
										<div class="w-2 h-2 rounded-full
											@switch($account->status)
												@case(0) bg-red-500   @break
												@case(1) bg-amber-500 @break
												@case(2) bg-teal-500  @break
												@default
											@endswitch
										"></div>
										<div>
											{{ $account->sum_hours }} / {{ $account->total_hours }}
										</div>
									</div>
								@endif
							</td>
							<td>
								<div class="flex flex-row justify-end pr-2">
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
				{{-- archived accounts table --}}
				<table x-show="active === 'archived'" class="items-center bg-transparent w-full border-collapse">
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
								{{ __('Archiviert am') }}
							</th>
							<th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($archivedAccounts as $i => $account)
						<tr class="{{ $i%2 == 1 ? 'bg-slate-50' : ''}} hover:bg-slate-200">
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
								{{ hdate($account->start) }}
							</td>
							<td class="px-6 py-4 align-center whitespace-nowrap">
								{{ hdate($account->archived_at) }}
							</td>
							<td>
								<div class="flex flex-row justify-end pr-2">
									{{-- link to recycle archived account --}}
									<form method="POST" action="{{ route('accounts-recycle', $account->id) }}">
										@csrf
										<button class="transition duration-150 ease-in-out">
											<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-teal-600 hover:stroke-teal-500 stroke-2" viewBox="0 0 24 24">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
												<path d="M12 17l-2 2l2 2m-2 -2h9a2 2 0 0 0 1.75 -2.75l-.55 -1" />
												<path d="M12 17l-2 2l2 2m-2 -2h9a2 2 0 0 0 1.75 -2.75l-.55 -1" transform="rotate(120 12 13)" />
												<path d="M12 17l-2 2l2 2m-2 -2h9a2 2 0 0 0 1.75 -2.75l-.55 -1" transform="rotate(240 12 13)" />
											</svg>
										</button>
									</form>

									{{-- dialog to archive existing account --}}
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
											{{ __('Konto löschen') }}
										</x-slot>

										<div class="mb-4">
											{{ __('Möchtest du dieses Konto wirklich endgültig löschen? Das kann nicht rückgängig gemacht werden.') }}
										</div>

										<x-slot name="action">
											<form method="POST" action="{{ route('accounts-delete', $account->id) }}">
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
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</x-app-layout>
