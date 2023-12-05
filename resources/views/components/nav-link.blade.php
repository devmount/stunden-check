@props(['active'])

@php
$classes = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 focus:outline-none transition-colors '
	. (($active ?? false)
		? '!border-teal-600 text-gray-900 dark:text-white focus:border-teal-700'
		: 'text-gray-500 dark:text-gray-400 hover:text-gray-700 hover:dark:text-white hover:border-gray-300 hover:dark:border-gray-500 focus:text-gray-700 focus:dark:text-white focus:border-gray-300 focus:dark:border-gray-500');
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
	{{ $slot }}
</a>
