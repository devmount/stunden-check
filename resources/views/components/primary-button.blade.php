@props(['add'])

<button
	{{ $attributes->merge([
		'type' => 'submit',
		'class' => 'inline-flex items-center px-4 py-2 bg-teal-800 dark:bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring ring-teal-200 disabled:opacity-25 transition-colors'
	]) }}
>
	@isset($add)
		<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
			<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
			<line x1="12" y1="5" x2="12" y2="19" />
			<line x1="5" y1="12" x2="19" y2="12" />
		</svg>
	@endisset
	{{ $slot }}
</button>
