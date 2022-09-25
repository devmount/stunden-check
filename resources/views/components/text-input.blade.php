@props([
	'label' => '',
	'disabled' => false,
	'required' => false,
	'autofocus' => false
])

<label class="{{ $attributes['class'] }}">
	<span class="mb-1 text-sm text-gray-700">{{ $label ?? $slot }}</span>
	<input
		{{ $disabled ? 'disabled' : '' }}
		class="block w-full rounded-md shadow-sm border-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50"
		type="{{ $attributes['type'] }}"
		name="{{ $attributes['name'] }}"
		value="{{ $attributes[':value'] }}"
		{{ $required ? 'required' : '' }}
		{{ $autofocus ? 'autofocus' : '' }}
	/>
</label>
