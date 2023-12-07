<x-app-layout>
	<x-slot name="header">
		<h2>
			{{ __('Einstellungen') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-content-card
				x-data="{
					tabs: ['param', 'email'],
					active: '{{ $view ?? 'param' }}',
				}"
			>
				<div class="px-6 pb-4 flex flex-col-reverse sm:flex-row gap-4 justify-between items-center">
					<div class="inline-flex bg-gray-100 dark:bg-gray-700 rounded-lg self-start sm:self-center gap-1 p-2">
						<button
							@click="active = 'param'"
							:class="[
								active === 'param' && 'bg-white text-black shadow',
								active !== 'param' && 'text-gray-600 dark:text-gray-400'
							]"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg transition-colors"
						>
							{{ __('Anwendungs-Parameter') }}
						</button>
						<button
							@click="active = 'cat'"
							:class="[
								active === 'cat' && 'bg-white text-black shadow',
								active !== 'cat' && 'text-gray-600 dark:text-gray-400'
							]"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg transition-colors"
						>
							{{ __('Tätigkeitsbereiche') }}
						</button>
						<button
							@click="active = 'email'"
							:class="[
								active === 'email' && 'bg-white text-black shadow',
								active !== 'email' && 'text-gray-600 dark:text-gray-400'
							]"
							class="py-2 px-4 inline-flex items-center justify-center text-center rounded-lg transition-colors"
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
					<table>
						<thead>
							<tr>
								<th class="text-left">
									{{ __('Titel') }}
								</th>
								<th class="max-w-[200px] md:max-w-none truncate text-left">
									{{ __('Beschreibung') }}
								</th>
								<th class="w-20 text-left">
								</th>
							</tr>
						</thead>
						<tbody>
						@forelse ($categories->sortBy('title') as $category)
							<tr>
								<td class="text-left">
									{{ $category->title }}
								</td>
								<td class="text-left max-w-[200px] md:max-w-none truncate">
									{{ $category->description }}
								</td>
								<td>
									<div class="flex gap-2">
										{{-- dialog to edit existing category --}}
										<x-text-button
											onclick="window.location='{{ route('categories-edit', $category->id) }}'"
											class="text-teal-600 hover:text-teal-500"
											title="{{ __('Bearbeiten') }}"
											edit
										/>

										{{-- dialog to delete existing category --}}
										<x-modal class="max-w-lg">
											<x-slot name="trigger">
												<x-text-button
													class="text-red-600 hover:text-red-500"
													title="{{ __('Löschen') }}"
													delete
												/>
											</x-slot>

											<x-slot name="title">
												{{ __('Bereich löschen') }}
											</x-slot>

											<div class="mb-4">
												{{ __('Möchtest du den Tätigkeitsbereich »' . $category->title . '« wirklich löschen?') }}
											</div>

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
								<td colspan="4" class="p-8 text-center">
									{{ __('Hier sind noch keine Einträge vorhanden.') }}
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
			</x-content-card>
		</div>
	</div>
</x-app-layout>
