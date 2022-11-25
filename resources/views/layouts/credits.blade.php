<div class="max-w-7xl mx-auto px-2 sm:px-8 lg:px-10 pb-12 mt-8 flex flex-col justify-between gap-4">
	<div>
		<div class="max-w-xs text-xs text-gray-500">
			{{ config('app.name', 'StundenCheck') }} ist ein Open-Source-Projekt zur Verwaltung der Beteiligung in Initiativeinrichtungen.
			Erstellt von <a href="https://devmount.de" class="underline" target="_blank">devmount</a>.
		</div>
		<div class="flex items-center mt-4">
			<svg viewBox="0 0 24 24" class="stroke-current stroke-2 fill-transparent -mt-px w-5 h-5 text-gray-400">
				<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
				<path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" />
			</svg>
	
			<a href="https://github.com/devmount/stunden-check" class="ml-1 text-sm underline" target="_blank">
				GitHub
			</a>
	
			<svg viewBox="0 0 24 24" class="stroke-current stroke-2 fill-transparent ml-4 -mt-px w-5 h-5 text-gray-400">
				<path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
			</svg>
	
			<a href="https://paypal.me/devmount" class="ml-1 text-sm underline" target="_blank">
				Spende
			</a>
		</div>
	</div>
	
	<div>
		@if (auth()->user()->is_admin)
			<div class="flex flex-col sm:flex-row sm:gap-2 text-sm text-gray-500">
				<div>StundenCheck <code>v{{ config('app.version') }}</code></div>
				<div class="hidden sm:block">&middot;</div>
				<div>Laravel <code>v{{ Illuminate\Foundation\Application::VERSION }}</code></div>
				<div class="hidden sm:block">&middot;</div>
				<div>PHP <code>v{{ PHP_VERSION }}</code></div>
				<div class="hidden sm:block">&middot;</div>
				<div>Page loaded in <code>{{ round(microtime(true) - LARAVEL_START, 2) }}s</code></div>
			</div>
		@endif
	</div>
</div>
