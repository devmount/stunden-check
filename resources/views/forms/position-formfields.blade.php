<!-- date (no time needed) -->
<x-text-input
	id="date"
	class="block w-full"
	type="date"
	name="date"
	:label="__('Datum')"
	:value="old('date')"
	required
	autofocus
/>
<!-- hours -->
<x-text-input
	id="hours"
	class="block mt-4 w-full"
	type="number"
	name="hours"
	:label="__('Stundenanzahl')"
	:value="old('hours')"
	required
/>
<!-- description -->
<x-text-input
	id="description"
	class="block mt-4 w-full"
	type="text"
	name="description"
	:label="__('Beschreibung der Tätigkeit')"
	:value="old('description')"
	required
/>
