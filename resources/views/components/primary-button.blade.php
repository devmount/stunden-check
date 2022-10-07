<button
	{{ $attributes->merge([
		'type' => 'submit',
		'class' => 'inline-flex items-center px-4 py-2 bg-teal-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring ring-teal-200 disabled:opacity-25 transition ease-in-out duration-150'
	]) }}
>
	{{ $slot }}
</button>
