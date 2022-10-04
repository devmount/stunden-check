@props([
	'label' => 'Bitte auswählen',
	'disabled' => false,
	'required' => false,
	'autofocus' => false
])

<label class="{{ $attributes['class'] }}">
	<span class="mb-1 text-sm text-gray-700">
		{{ $label }}
		@if ($required) <span class="text-red-400">*</span> @endif
	</span>
	<select
		class="block w-full rounded-md shadow-sm border-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50 @error($attributes['name']) border-red-400 @enderror"
		name="{{ $attributes['name'] }}"
		{{ $disabled ? 'disabled' : '' }}
		{{ $required ? 'required' : '' }}
		{{ $autofocus ? 'autofocus' : '' }}
	>
		{{ $slot }}
	</select>
</label>
@error($attributes['name'])
	<div class="text-sm text-red-600">{{ $message }}</div>
@enderror
