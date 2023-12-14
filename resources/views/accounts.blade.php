<x-app-layout>
	<x-slot name="header">
		<h2 class="flex flex-col sm:flex-row gap-6 justify-between items-center">
			<div>{{ __('Übersicht Konten') }}</div>
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
			<x-content-card
				x-data="{
					tabs: ['active', 'archived'],
					active: 'active',
				}"
			>
				<div class="px-6 pb-4 flex flex-col-reverse sm:flex-row gap-4 justify-between items-center">
					<div class="inline-flex bg-gray-100 dark:bg-gray-700 rounded-lg self-start sm:self-center gap-1 p-2">
						<button
							@click="active = 'active'"
							:class="[
								active === 'active' && 'bg-white text-black shadow',
								active !== 'active' && 'text-gray-600 dark:text-gray-400'
							]"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							Aktive Konten
							@if (count($activeAccounts) > 0)
								<span class="inline-block ml-3 font-bold">{{ count($activeAccounts) }}</span>
							@endif
						</button>
						<button
							@click="active = 'archived'"
							:class="[
								active === 'archived' && 'bg-white text-black shadow',
								active !== 'archived' && 'text-gray-600 dark:text-gray-400'
							]"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							Archiv
							@if (count($archivedAccounts) > 0)
								<span class="inline-block ml-3 font-bold">{{ count($archivedAccounts) }}</span>
							@endif
						</button>
					</div>
					<div class="flex gap-6 items-center self-end sm:self-center">
						{{-- dialog to add new account --}}
						<x-primary-button onclick="window.location='{{ route('accounts-add') }}'" add >
							{{ __('Neues Konto') }}
						</x-primary-button>
						{{-- dropdown with addition functions --}}
						<x-dropdown align="right">
							<x-slot name="trigger">
								<button class="group flex justify-center items-center p-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
										<line x1="4" y1="6" x2="20" y2="6" />
										<line x1="4" y1="12" x2="20" y2="12" />
										<line x1="4" y1="18" x2="20" y2="18" />
									</svg>
								</button>
							</x-slot>
							<x-slot name="content">
								{{-- email reminder --}}
								<x-dropdown-link :href="url('accounts/reminder')" mail>
									{{ __('E-Mail-Erinnerung') }}
								</x-dropdown-link>
								<hr />
								{{-- export accounts as xlsx --}}
								<x-dropdown-link :href="url('accounts/export/xlsx')" xlsx>
									{{ __('Export Excel') }}
								</x-dropdown-link>
								{{-- export accounts as csv --}}
								<x-dropdown-link :href="url('accounts/export/csv')" csv>
									{{ __('Export CSV') }}
								</x-dropdown-link>
							</x-slot>
						</x-dropdown>
					</div>
				</div>
				<div class="overflow-x-scroll">
					{{-- active accounts table --}}
					<table x-show="active === 'active'">
						<thead>
							<tr>
								<th class="text-left">&num;</th>
								<th class="text-left">{{ __('Personen') }}</th>
								<th class="text-left">{{ __('Eingestiegen am') }}</th>
								<th class="text-left">{{ __('Tage Befreit') }}</th>
								<th class="text-left">{{ __('Status') }}</th>
								<th class="text-left"></th>
							</tr>
						</thead>
						<tbody>
						@foreach ($activeAccounts as $account)
							<tr>
								<td class="whitespace-nowrap text-left">
									{{ $account->id }}
								</td>
								<td class="whitespace-nowrap text-left">
									<div class="flex flex-row gap-4">
									@foreach ($account->users as $user)
										<div class="flex gap-2" title="{{ $user->is_admin ? 'Administrator' : '' }}">
											<svg
												xmlns="http://www.w3.org/2000/svg"
												class="
													w-6 h-6 fill-transparent stroke-1
													{{ $user->is_admin ? 'stroke-teal-600 fill-teal-600' : 'stroke-current' }}
												"
												viewBox="0 0 24 24"
											>
												<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
												<circle cx="12" cy="7" r="4" />
												<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
											</svg>
											{{ $user->firstname }} {{ $user->lastname }}
										</div>
									@endforeach
									{{ $account->note ? '(' . $account->note . ')' : '' }}
									</div>
								</td>
								<td class="whitespace-nowrap">
									{{ hdate($account->start) }}
								</td>
								<td class="whitespace-nowrap">
									@if ($account->separate_accounting)
										<div class="flex gap-4 items-center">
											@foreach ($account->users as $user)
												<div class="flex gap-2 items-center">
													<div class="w-2 h-2 rounded-full bg-gray-300"></div>
													<div>{{ $user->excemptionDaysByCycle($selectedStart) }}</div>
												</div>
											@endforeach
										</div>
									@else
										<div class="flex gap-2 items-center">
											<div class="w-2 h-2 rounded-full bg-gray-300"></div>
											<div>{{ $account->excemptionDaysByCycle($selectedStart) }}</div>
										</div>
									@endif
								</td>
								<td class="whitespace-nowrap">
									@if ($account->separate_accounting)
										<div class="flex gap-4 items-center">
											@foreach ($account->users as $user)
												<div class="flex gap-2 items-center">
													<div class="w-2 h-2 rounded-full
														@switch($user->statusByCycle($selectedStart))
															@case(0) bg-red-500   @break
															@case(1) bg-amber-500 @break
															@case(2) bg-teal-500  @break
															@default
														@endswitch
														"></div>
													<div>
														{{ $user->sumHoursByCycle($selectedStart) }} / {{ round($user->totalHoursByCycle($selectedStart), 1) }}
													</div>
												</div>
											@endforeach
										</div>
									@else
										<div class="flex gap-2 items-center">
											<div class="w-2 h-2 rounded-full
												@switch($account->statusByCycle($selectedStart))
													@case(0) bg-red-500   @break
													@case(1) bg-amber-500 @break
													@case(2) bg-teal-500  @break
													@default
												@endswitch
											"></div>
											<div>
												{{ $account->sumHoursByCycle($selectedStart) }} / {{ round($account->totalHoursByCycle($selectedStart), 1) }}
											</div>
										</div>
									@endif
								</td>
								<td>
									<div class="flex flex-row justify-end items-center gap-2 pr-2">
										{{-- link to show positions of existing account --}}
										<x-text-button
											onclick="window.location='{{ route('accounts-positions', $account->id) }}'"
											class="text-teal-600 hover:text-teal-500"
											title="Einträge auflisten"
											list
										/>

										{{-- link to edit existing account --}}
										<x-text-button
											onclick="window.location='{{ route('accounts-edit', $account->id) }}'"
											class="text-teal-600 hover:text-teal-500"
											title="{{ __('Bearbeiten') }}"
											edit
										/>

										{{-- dialog to archive existing account --}}
										<x-modal class="max-w-lg">
											<x-slot name="trigger">
												<x-text-button
													class="text-red-600 hover:text-red-500"
													title="{{ __('Archivieren') }}"
													archive
												/>
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
					<table x-show="active === 'archived'">
						<thead>
							<tr>
								<th class="text-left">&num;</th>
								<th class="text-left">{{ __('Personen') }}</th>
								<th class="text-left">{{ __('Eingestiegen am') }}</th>
								<th class="text-left">{{ __('Archiviert am') }}</th>
								<th class="text-left"></th>
							</tr>
						</thead>
						<tbody>
						@foreach ($archivedAccounts as $account)
							<tr>
								<td class="whitespace-nowrap text-left">
									{{ $account->id }}
								</td>
								<td class="whitespace-nowrap text-left">
									<div class="flex flex-row gap-4">
									@foreach ($account->users as $user)
										<div class="flex gap-2" title="{{ $user->is_admin ? 'Administrator' : '' }}">
											<svg
												xmlns="http://www.w3.org/2000/svg"
												class="
													w-6 h-6 fill-transparent stroke-1
													{{ $user->is_admin ? 'stroke-teal-600 fill-teal-600' : 'stroke-current' }}
												"
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
								<td class="whitespace-nowrap">
									{{ hdate($account->start) }}
								</td>
								<td class="whitespace-nowrap">
									{{ hdate($account->archived_at) }}
								</td>
								<td>
									<div class="flex flex-row justify-end items-center gap-2 pr-2">
										{{-- link to recycle archived account --}}
										<x-text-button
											onclick="window.location='{{ route('accounts-recycle', $account->id) }}'"
											class="text-teal-600 hover:text-teal-500"
											title="{{ __('Konto wieder aktivieren') }}"
											recycle
										/>

										{{-- dialog to delete existing account --}}
										<x-modal class="max-w-lg">
											<x-slot name="trigger">
												<x-text-button
													class="text-red-600 hover:text-red-500"
													title="{{ __('Löschen') }}"
													delete
												/>
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
			</x-content-card>
		</div>
	</div>
</x-app-layout>
