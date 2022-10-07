<div class="flex gap-4">
  <!-- active -->
  <x-checkbox-input
	name="active"
	class="w-1/2"
	:label="__('Aktiv')"
	:checked="old('active', isset($account) ? $account->active : false)"
  />
  <!-- separate_accounting -->
  <x-checkbox-input
	name="separate_accounting"
	class="w-1/2"
	:label="__('Getrennte Abrechnung')"
	:checked="old('separate_accounting', isset($account) ? $account->separate_accounting : false)"
  />
</div>

<div class="flex gap-4 mt-4">
  <!-- date (no time needed) -->
  <x-text-input
	class="block w-1/2"
	type="date"
	name="start"
	:value="old('start', isset($account) ? date('Y-m-d', strtotime($account->start)) : null)"
	:label="__('Datum Einstieg')"
	required
  />
  <!-- hours -->
  <x-text-input
	class="block w-1/2"
	type="number"
	name="target_hours"
	:value="old('target_hours', isset($account) ? $account->target_hours : null)"
	:label="__('Mindestanzahl Pflichtstunden')"
	required
  />
</div>

<div class="mt-8 flex gap-4">
  <!-- first person -->
  <div class="w-1/2">
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
	  class="block mt-4"
	  :label="__('Administrator')"
	  :checked="old('is_admin1', isset($account) ? $account->users[0]->is_admin : false)"
	/>
  </div>

  <!-- second person -->
  <div class="w-1/2">
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
	  class="block mt-4"
	  :label="__('Administrator')"
	  :checked="old('is_admin2', isset($account) && isset($account->users[1]) ? $account->users[1]->is_admin : false)"
	/>
  </div>
</div>

<div
  class="mt-8"
  x-data="{ list: {{ isset($account) ? collect($account->excemptions) : '[]' }}, add: 0, remove: []}"
>
  <!-- excemptions for account -->
  <h3 class="text-xl">Befreiung von der Stundenpflicht</h3>
  <template x-for="ex in list">
	<template x-if="! remove.includes(ex.id)">
	  <div class="flex gap-4 mt-2 items-center">
		<div x-text="new Date(ex.start).toLocaleDateString('de-DE', { year: 'numeric', month: 'long', day: 'numeric' })"></div>
		&mdash;
		<div x-text="new Date(ex.end).toLocaleDateString('de-DE', { year: 'numeric', month: 'long', day: 'numeric' })"></div>
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
  <input type="hidden" name="ex_delete" x-bind:value="remove">
  <template x-for="i in add">
	<div class="flex gap-4 mt-2 items-center">
	  <!-- start date -->
	  <input
			class="block w-full rounded-md shadow-sm border-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
		type="date"
		name="ex_start[]"
		required
	  />
	  <!-- end date -->
	  bis
	  <input
		class="block w-full rounded-md shadow-sm border-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
		type="date"
		name="ex_end[]"
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
