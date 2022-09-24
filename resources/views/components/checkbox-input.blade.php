@props(['label'])

<label {{ $attributes->merge(['class' => 'inline-flex items-center']) }}>
	<input
		id="{{ $attributes['for'] }}"
		type="checkbox"
		class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
		name="{{ $attributes['for'] }}"
	>
	<span class="ml-2">{{ $label ?? $slot }}</span>
</label>
