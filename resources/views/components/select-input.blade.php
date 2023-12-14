@props([
	'label' => 'Bitte auswählen',
	'disabled' => false,
	'required' => false,
	'autofocus' => false,
	'getNav' => false,
])

<label class="flex flex-col gap-2 {{ $attributes['class'] }}">
	{{-- label --}}
	@if ($label)
		<span class="text-sm text-gray-700 dark:text-gray-300">
			{{ $label }}
			@if ($required) <span class="text-red-400">*</span> @endif
		</span>
	@endif
	{{-- input --}}
	<select
		class="block w-ful @error($attributes['name']) border-red-400 dark:!border-red-500 @enderror"
		name="{{ $attributes['name'] }}"
		{{ $disabled ? 'disabled' : '' }}
		{{ $required ? 'required' : '' }}
		{{ $autofocus ? 'autofocus' : '' }}
		@if ($getNav)
			x-data
			@change="window.location.search = '?start=' + $event.target.value;"
		@endif
	>
		{{ $slot }}
	</select>
</label>
{{-- error message --}}
@error($attributes['name'])
	<div class="text-sm text-red-600 dark:!border-red-500">
		{{ $message }}
	</div>
@enderror
{{-- info message --}}
@if ($attributes['info'])
	<div class="text-sm mt-1 text-gray-400 dark:text-gray-500">
		{{ $attributes['info'] }}
	</div>
@endif
