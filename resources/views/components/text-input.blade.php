@props([
	'label' => '',
	'disabled' => false,
	'required' => false,
	'autofocus' => false,
])

<label class="{{ $attributes['class'] }}">
	{{-- label --}}
	<span class="mb-1 text-sm text-gray-700 dark:text-gray-300">
		{{ $label ?? $slot }}
		@if ($required) <span class="text-red-400">*</span> @endif
	</span>
	{{-- input --}}
	<input
		{{ $disabled ? 'disabled' : '' }}
		class="
			block w-full
			@error($attributes['name']) !border-red-400 dark:!border-red-500 @enderror
		"
		type="{{ $attributes['type'] }}"
		name="{{ $attributes['name'] }}"
		value="{{ $attributes['value'] }}"
		{{ $attributes['step'] ? 'step=' . $attributes['step'] : '' }}
		{{ $attributes['min'] ? 'min=' . $attributes['min'] : '' }}
		{{ $attributes['max'] ? 'max=' . $attributes['max'] : '' }}
		{{ $required ? 'required' : '' }}
		{{ $autofocus ? 'autofocus' : '' }}
	/>
</label>
{{-- error message --}}
@error($attributes['name'])
	<div class="text-sm text-red-600 dark:text-red-400">
		{{ $message }}
	</div>
@enderror
{{-- info message --}}
@if ($attributes['info'])
	<div class="text-sm mt-1 text-gray-400 dark:text-gray-500">
		{{ $attributes['info'] }}
	</div>
@endif
