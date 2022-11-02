<div class="flex gap-4 mt-4">
	<div class="w-1/2">
		<!-- date (no time needed) -->
		<x-text-input
			class="block w-full"
			type="date"
			name="completed_at"
			:label="__('Datum')"
			:value="old('completed_at', isset($position) ? date('Y-m-d', strtotime($position->completed_at)) : date('Y-m-d'))"
			required
			autofocus
		/>
	</div>
	<div class="w-1/2">
		<!-- hours -->
		<x-text-input
			class="block w-full"
			type="number"
			name="hours"
			:label="__('Stundenanzahl')"
			:value="old('hours', isset($position) ? $position->hours : null)"
			step="0.25"
			min="0.25"
			required
		/>
	</div>
</div>
<div class="flex gap-4 mt-4">
	<div class="w-1/2">
		<!-- hours -->
		<x-select-input
			class="block w-full"
			name="category_id"
			:label="__('Tätigkeitsbereich')"
			required
		>
			@foreach ($categories as $c)
				<option
					{{ old('category_id', $position['category_id'] ?? null) == $c->id ? 'selected' : '' }}
					value="{{ $c->id}}"
				>
					{{ $c->title }}
				</option>
			@endforeach
		</x-select-input>
	</div>
	<div class="w-1/2">
		<!-- description -->
		<x-text-input
			class="block w-full"
			type="text"
			name="description"
			:label="__('Beschreibung der Tätigkeit')"
			:value="old('description', isset($position) ? $position->description : null)"
			required
		/>
	</div>
</div>
