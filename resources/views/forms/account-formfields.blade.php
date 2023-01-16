<div class="flex flex-col sm:flex-row gap-4">
	<div class="sm:w-1/2">
		<!-- active -->
		<x-checkbox-input
			name="active"
			:label="__('Aktiv')"
			:info="__('Aktive Konten werden ausgewertet, inaktive Konten sind im Archiv gelistet.')"
			:checked="old('active', isset($account) ? $account->active : true)"
		/>
	</div>
	<div class="sm:w-1/2">
		<!-- separate_accounting -->
		<x-checkbox-input
			name="separate_accounting"
			:label="__('Getrennte Abrechnung')"
			:info="__('Bei getrennter Abrechnung werden die zugeordneten Personen einzeln ausgewertet.')"
			:checked="old('separate_accounting', isset($account) ? $account->separate_accounting : false)"
		/>
	</div>
</div>

<div class="flex flex-col sm:flex-row gap-4 mt-4">
	<div class="sm:w-1/2">
		<!-- date (no time needed) -->
		<x-text-input
			type="date"
			name="start"
			:value="old('start', isset($account) ? date('Y-m-d', strtotime($account->start)) : $default_start)"
			:label="__('Datum Einstieg')"
			:info="__('Ist der Einstieg nicht zum Start der Abrechnungsperiode, so sind Stunden nur anteilig zu erbringen.')"
			required
		/>
	</div>
	<div class="sm:w-1/2">
		<!-- hours -->
		<x-text-input
			type="number"
			name="target_hours"
			:value="old('target_hours', isset($account) ? $account->target_hours : $default_hours)"
			:label="__('Mindestanzahl Pflichtstunden')"
			:info="__('Gilt immer für das gesamte Konto. Bei getrennter Abrechnung ist von jeder Person die Hälfte zu erbringen.')"
			step="0.25"
			min="0.25"
			required
		/>
	</div>
</div>

<div class="flex flex-col sm:flex-row gap-4 mt-4">
	<div class="sm:w-1/2">
		<!-- note -->
		<x-text-input
			type="text"
			name="note"
			value="{!! old('note', isset($account) ? $account->note : null) !!}"
			:label="__('Kontoinformation')"
			:info="__('Zusätzliche interne Information zum Konto. Wird nur für Administratoren in der Kontoübersicht angezeigt.')"
		/>
	</div>
	<div class="sm:w-1/2">
	</div>
</div>

<div class="mt-8 flex flex-col sm:flex-row gap-4">
	<!-- first person -->
	<div class="sm:w-1/2">
		<h3 class="text-xl">1. Person</h3>
		<!-- 1. firstname -->
		<x-text-input
			class="mt-4 block w-full"
			type="text"
			name="firstname1"
			:value="old('firstname1', isset($account) ? $account->users[0]->firstname : null)"
			:label="__('Vorname')"
			required
		/>
		<!-- 1. lastname -->
		<x-text-input
			class="mt-4 block w-full"
			type="text"
			name="lastname1"
			:value="old('lastname1', isset($account) ? $account->users[0]->lastname : null)"
			:label="__('Nachname')"
			required
		/>
		<!-- 1. email -->
		<x-text-input
			class="mt-4 block w-full"
			type="email"
			name="email1"
			:value="old('email1', isset($account) ? $account->users[0]->email : null)"
			:label="__('E-Mail-Adresse')"
			required
		/>
		<!-- 1. is_admin -->
		<x-checkbox-input
			name="is_admin1"
			class="block mt-4 mb-4"
			:label="__('Administrator')"
			:checked="old('is_admin1', isset($account) ? $account->users[0]->is_admin : false)"
		/>
		<!-- excemptions for user1 -->
		<div x-data="{ list: {{ isset($account) && isset($account->users[0]) ? collect($account->users[0]->excemptions) : '[]' }}, add: 0, remove: []}">
			<div class="text-sm">Befreiung von der Stundenpflicht</div>
			<template x-for="ex in list">
				<template x-if="! remove.includes(ex.id)">
					<div class="flex gap-4 mt-2 items-center">
						<div class="hidden lg:inline" x-text="new Date(ex.start).toLocaleDateString('de-DE', { year: 'numeric', month: 'long', day: 'numeric' })"></div>
						<div class="lg:hidden" x-text="new Date(ex.start).toLocaleDateString('de-DE', { year: '2-digit', month: 'numeric', day: 'numeric' })"></div>
						&mdash;
						<div class="hidden lg:inline" x-text="new Date(ex.end).toLocaleDateString('de-DE', { year: 'numeric', month: 'long', day: 'numeric' })"></div>
						<div class="lg:hidden" x-text="new Date(ex.end).toLocaleDateString('de-DE', { year: '2-digit', month: 'numeric', day: 'numeric' })"></div>
						<button
							class="transition duration-150 ease-in-out"
							@click="event.preventDefault();remove.push(ex.id);"
						>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-transparent stroke-red-600 hover:stroke-red-500 stroke-2" viewBox="0 0 24 24">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
								<line x1="18" y1="6" x2="6" y2="18" />
								<line x1="6" y1="6" x2="18" y2="18" />
							</svg>
						</button>
					</div>
				</template>
			</template>
			<input type="hidden" name="ex_delete1" x-bind:value="remove">
			<template x-for="i in add">
				<div class="flex gap-4 mt-2 items-center">
					<!-- start date -->
					<input
						class="block w-full rounded-md shadow-sm border-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
						type="date"
						name="ex_start1[]"
						required
					/>
					<!-- end date -->
					bis
					<input
						class="block w-full rounded-md shadow-sm border-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
						type="date"
						name="ex_end1[]"
						required
					/>
				</div>
			</template>
			<button
				class="transition duration-150 ease-in-out mt-2"
				@click="event.preventDefault();add++;"
				>
				<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-teal-600 hover:stroke-teal-500 stroke-2" viewBox="0 0 24 24">
					<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
					<line x1="12" y1="5" x2="12" y2="19" />
					<line x1="5" y1="12" x2="19" y2="12" />
				</svg>
			</button>
		</div>
	</div>

	<!-- second person -->
	<div class="sm:w-1/2">
		<h3 class="text-xl">2. Person (optional)</h3>
		<!-- 2. firstname -->
		<x-text-input
			class="mt-4 block w-full"
			type="text"
			name="firstname2"
			:value="old('firstname2', isset($account) && isset($account->users[1]) ? $account->users[1]->firstname : null)"
			:label="__('Vorname')"
		/>
		<!-- 2. lastname -->
		<x-text-input
			class="mt-4 block w-full"
			type="text"
			name="lastname2"
			:value="old('lastname2', isset($account) && isset($account->users[1]) ? $account->users[1]->lastname : null)"
			:label="__('Nachname')"
		/>
		<!-- 2. email -->
		<x-text-input
			class="mt-4 block w-full"
			type="email"
			name="email2"
			:value="old('email2', isset($account) && isset($account->users[1]) ? $account->users[1]->email : null)"
			:label="__('E-Mail-Adresse')"
		/>
		<!-- 2. is_admin -->
		<x-checkbox-input
			name="is_admin2"
			class="block mt-4 mb-4"
			:label="__('Administrator')"
			:checked="old('is_admin2', isset($account) && isset($account->users[1]) ? $account->users[1]->is_admin : false)"
		/>
		<!-- excemptions for user2 -->
		<div x-data="{ list: {{ isset($account) && isset($account->users[1]) ? collect($account->users[1]->excemptions) : '[]' }}, add: 0, remove: []}">
			<div class="text-sm">Befreiung von der Stundenpflicht</div>
			<template x-for="ex in list">
				<template x-if="! remove.includes(ex.id)">
					<div class="flex gap-4 mt-2 items-center">
						<div class="hidden lg:inline" x-text="new Date(ex.start).toLocaleDateString('de-DE', { year: 'numeric', month: 'long', day: 'numeric' })"></div>
						<div class="lg:hidden" x-text="new Date(ex.start).toLocaleDateString('de-DE', { year: '2-digit', month: 'numeric', day: 'numeric' })"></div>
						&mdash;
						<div class="hidden lg:inline" x-text="new Date(ex.end).toLocaleDateString('de-DE', { year: 'numeric', month: 'long', day: 'numeric' })"></div>
						<div class="lg:hidden" x-text="new Date(ex.end).toLocaleDateString('de-DE', { year: '2-digit', month: 'numeric', day: 'numeric' })"></div>
						<button
							class="transition duration-150 ease-in-out"
							@click="event.preventDefault();remove.push(ex.id);"
						>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-transparent stroke-red-600 hover:stroke-red-500 stroke-2" viewBox="0 0 24 24">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
								<line x1="18" y1="6" x2="6" y2="18" />
								<line x1="6" y1="6" x2="18" y2="18" />
							</svg>
						</button>
					</div>
				</template>
			</template>
			<input type="hidden" name="ex_delete2" x-bind:value="remove">
			<template x-for="i in add">
				<div class="flex gap-4 mt-2 items-center">
					<!-- start date -->
					<input
						class="block w-full rounded-md shadow-sm border-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
						type="date"
						name="ex_start2[]"
						required
					/>
					<!-- end date -->
					bis
					<input
						class="block w-full rounded-md shadow-sm border-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
						type="date"
						name="ex_end2[]"
						required
					/>
				</div>
			</template>
			<button
				class="transition duration-150 ease-in-out mt-2"
				@click="event.preventDefault();add++;"
				>
				<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-teal-600 hover:stroke-teal-500 stroke-2" viewBox="0 0 24 24">
					<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
					<line x1="12" y1="5" x2="12" y2="19" />
					<line x1="5" y1="12" x2="19" y2="12" />
				</svg>
			</button>
		</div>
	</div>
</div>
