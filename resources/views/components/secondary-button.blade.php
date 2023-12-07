<button
	{{ $attributes->merge([
		'type' => 'submit',
		'class' => 'inline-flex items-center px-4 py-2 bg-gray-400 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 hover:dark:bg-gray-600 active:bg-gray-500 focus:outline-none focus:border-gray-600 focus:ring ring-gray-200 disabled:opacity-25 transition-colors'
	]) }}
>
	{{ $slot }}
</button>
