@props(['active'])

@php
$classes = 'block pl-3 pr-4 py-2 border-l-4 text-base font-medium focus:outline-none transition-colors '
	. (($active ?? false)
		? '!border-teal-400 text-teal-700 dark:text-teal-300 !bg-teal-50 dark:!bg-teal-900 focus:text-teal-800 focus:dark:text-teal-200 focus:!bg-teal-100 focus:dark:!bg-teal-800 focus:!border-teal-700 focus:dark:!border-white'
		: 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-800 hover:dark:text-white hover:bg-gray-50 hover:dark:bg-gray-700 hover:border-gray-300 hover:dark:border-gray-500 focus:text-gray-800 focus:dark:text-white focus:bg-gray-50 focus:dark:bg-gray-700 focus:border-gray-300 focus:dark:border-gray-500');
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
	{{ $slot }}
</a>
