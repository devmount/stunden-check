@props(['add', 'edit', 'delete', 'close', 'archive', 'list', 'recycle'])

<button {{ $attributes->merge(['class' => 'transition-colors']) }}>
	@isset($list)
		<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
			<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
			<line x1="9" y1="6" x2="20" y2="6" />
			<line x1="9" y1="12" x2="20" y2="12" />
			<line x1="9" y1="18" x2="20" y2="18" />
			<line x1="5" y1="6" x2="5" y2="6.01" />
			<line x1="5" y1="12" x2="5" y2="12.01" />
			<line x1="5" y1="18" x2="5" y2="18.01" />
		</svg>
	@endisset
	@isset($add)
		<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
			<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
			<line x1="12" y1="5" x2="12" y2="19" />
			<line x1="5" y1="12" x2="19" y2="12" />
		</svg>
	@endisset
	@isset($edit)
		<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
			<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
			<path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
			<path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
			<line x1="16" y1="5" x2="19" y2="8" />
		</svg>
	@endisset
	@isset($delete)
		<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
			<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
			<line x1="4" y1="7" x2="20" y2="7" />
			<line x1="10" y1="11" x2="10" y2="17" />
			<line x1="14" y1="11" x2="14" y2="17" />
			<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
			<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
		</svg>
	@endisset
	@isset($archive)
		<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
			<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
			<rect x="3" y="4" width="18" height="4" rx="2" />
			<path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" />
			<line x1="10" y1="12" x2="14" y2="12" />
		</svg>
	@endisset
	@isset($close)
		<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
			<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
			<line x1="18" y1="6" x2="6" y2="18" />
			<line x1="6" y1="6" x2="18" y2="18" />
		</svg>
	@endisset
	@isset($recycle)
		<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-transparent stroke-current stroke-2" viewBox="0 0 24 24">
			<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
			<path d="M12 17l-2 2l2 2m-2 -2h9a2 2 0 0 0 1.75 -2.75l-.55 -1" />
			<path d="M12 17l-2 2l2 2m-2 -2h9a2 2 0 0 0 1.75 -2.75l-.55 -1" transform="rotate(120 12 13)" />
			<path d="M12 17l-2 2l2 2m-2 -2h9a2 2 0 0 0 1.75 -2.75l-.55 -1" transform="rotate(240 12 13)" />
		</svg>
	@endisset
	{{ $slot }}
</button>
