@props([
	'label' => '',
	'name' => '',
	'checked' => false
])

<label class="{{ $attributes['class'] }}">
	<input
		type="checkbox"
		class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
		name="{{ $name }}"
		value="1"
		{{ $checked ? 'checked' : '' }}
	/>
	<span class="ml-2">{{ $label ?? $slot }}</span>
</label>
@if ($attributes['info'])
	<div class="text-sm mt-2 py-1 px-2 text-slate-500 border-l-4 border-slate-400 bg-slate-50">
		{{ $attributes['info'] }}
	</div>
@endif
