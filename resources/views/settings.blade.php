<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Einstellungen') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div
				class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 border-b border-gray-200"
				x-data="{
					tabs: ['param', 'email'],
					active: '{{ $view ?? 'param' }}',
				}"
			>
				<div class="px-6 pb-4 flex flex-col lg:flex-row gap-4 justify-between items-center">
					<div class="inline-flex flex-col sm:flex-row bg-slate-100 rounded-lg gap-1 p-2">
						<button
							@click="active = 'param'"
							:class="[active === 'param' && 'bg-white text-black shadow', active !== 'param' && 'text-slate-600']"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							{{ __('Anwendungs-Parameter') }}
						</button>
						<button
							@click="active = 'cat'"
							:class="[active === 'cat' && 'bg-white text-black shadow', active !== 'cat' && 'text-slate-600']"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							{{ __('Tätigkeitsbereiche') }}
						</button>
						<button
							@click="active = 'email'"
							:class="[active === 'email' && 'bg-white text-black shadow', active !== 'email' && 'text-slate-600']"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg"
						>
							{{ __('E-Mail Konfiguration') }}
						</button>
					</div>
					<div x-show="active === 'cat'" class="flex gap-6 items-center self-end lg:self-center">
						{{-- dialog to add new category --}}
						<x-primary-button onclick="window.location='{{ route('categories-add') }}'" class="transition duration-150 ease-in-out">
							<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-2 text-white" viewBox="0 0 24 24">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
								<line x1="12" y1="5" x2="12" y2="19" />
								<line x1="5" y1="12" x2="19" y2="12" />
							</svg>
							{{ __('Neuer Tätigkeitsbereich') }}
						</x-primary-button>
					</div>
				</div>
				{{-- app parameter --}}
				<div x-show="active === 'param'" class="px-6">
					<form method="POST" action="{{ route('settings') }}">
						@csrf
						@include('forms.parameter-formfields')
						
						<div class="flex justify-end gap-2 mt-8">
							<x-secondary-button onclick="event.preventDefault();window.location='{{ route('settings') }}'">
								{{ __('Abbrechen') }}
							</x-secondary-button>
							<x-primary-button>
								{{ __('Speichern') }}
							</x-primary-button>
						</div>
					</form>
				</div>
				{{-- categories --}}
				<div x-show="active === 'cat'">
					<div class="mb-4 px-6">
						{{ __('Verwalte hier die Tätigkeitsbereiche für Stundeneinträge.') }}
					</div>
					<table class="items-center bg-transparent w-full border-collapse">
						<thead>
							<tr>
								<th class="px-3 md:px-6 py-3 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 uppercase border-l-0 border-r-0 font-semibold text-left">
									{{ __('Titel') }}
								</th>
								<th class="px-3 md:px-6 py-3 bg-slate-50 text-slate-500 align-middle max-w-[200px] md:max-w-none overflow-hidden text-ellipsis whitespace-nowrap border border-solid border-slate-200 uppercase border-l-0 border-r-0 font-semibold text-left">
									{{ __('Beschreibung') }}
								</th>
								<th class="w-20 px-3 md:px-6 py-3 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 uppercase border-l-0 border-r-0 font-semibold text-left">
								</th>
							</tr>
						</thead>
						<tbody>
						@forelse ($categories->sortBy('title') as $category)
							<tr class="even:bg-slate-50 hover:bg-slate-200">
								<td class="px-3 md:px-6 py-3 md:py-4 align-middle text-left">
									{{ $category->title }}
								</td>
								<td class="px-3 md:px-6 py-3 md:py-4 align-middle text-left max-w-[200px] md:max-w-none overflow-hidden text-ellipsis whitespace-nowrap">
									{{ $category->description }}
								</td>
								<td>
									<div class="flex flex-row">
										{{-- dialog to edit existing category --}}
										<button onclick="window.location='{{ route('categories-edit', $category->id) }}'" class="transition duration-150 ease-in-out">
											<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-teal-600 hover:stroke-teal-500 stroke-2" viewBox="0 0 24 24">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
												<path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
												<path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
												<line x1="16" y1="5" x2="19" y2="8" />
											</svg>
										</button>

										{{-- dialog to delete existing category --}}
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
												{{ __('Bereich löschen') }}
											</x-slot>

											<div class="mb-4">{{ __('Möchtest du den Tätigkeitsbereich »' . $category->title . '« wirklich löschen?') }}</div>
											<form x-ref="delete{{ $category->id }}" method="POST" action="{{ route('categories-delete', $category->id) }}">
												@csrf
												<x-select-input
													class="block w-full"
													name="replacement"
													:label="__('Ersatz-Tätigkeitsbereich')"
													:info="__('Für alle bestehenden Einträge des Bereichs »' . $category->title . '« wird der hier angegebene Bereich gesetzt.')"
													required
												>
													@foreach ($categories->where('id', '!=', $category->id)->sortBy('title') as $c)
														<option value="{{ $c->id}}">
															{{ $c->title }}
														</option>
													@endforeach
												</x-select-input>
											</form>

											<x-slot name="action">
												<x-danger-button @click="$refs.delete{{ $category->id }}.submit()">
													{{ __('Löschen') }}
												</x-danger-button>
											</x-slot>
										</x-modal>
									</div>
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
				</div>
				{{-- email config --}}
				<div x-show="active === 'email'" class="px-6">
					<div class="mb-4">
						{{ __('Passe hier die E-Mail Einstellungen an und teste sie.') }}
					</div>
					<form method="POST" action="{{ route('testmail') }}">
						@csrf
						@include('forms.email-formfields')

						<div class="mt-4">
							<x-primary-button>
								{{ __('Test E-Mail senden') }}
							</x-primary-button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
