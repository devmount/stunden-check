@props([
	'label' => '',
	'name' => '',
	'checked' => false
])

<label class="{{ $attributes['class'] }}">
	<input
		type="checkbox"
		name="{{ $name }}"
		value="1"
		{{ $checked ? 'checked' : '' }}
	/>
	<span class="ml-2">{{ $label ?? $slot }}</span>
</label>
@if ($attributes['info'])
	<div class="text-sm mt-1 text-gray-400 dark:text-gray-500">
		{{ $attributes['info'] }}
	</div>
@endif
