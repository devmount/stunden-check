<div class="relative" x-data="{ open: false }">
	<div @click="open = ! open" class="flex">
		{{ $trigger }}
	</div>
	<div
		x-show="open"
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="transform opacity-0"
		x-transition:enter-end="transform opacity-100"
		x-transition:leave="transition ease-in duration-75"
		x-transition:leave-start="transform opacity-100"
		x-transition:leave-end="transform opacity-0"
		class="fixed top-0 left-0 w-full h-full outline-none overflow-x-hidden overflow-y-auto flex items-center justify-center z-10 bg-black/50"
		tabindex="-1"
		aria-hidden="true"
		style="display: none;"
	>
		<div {{ $attributes->merge(['class' => 'w-full shadow-lg relative flex flex-col pointer-events-auto bg-white dark:bg-gray-800 bg-clip-padding rounded-md text-current']) }}>
			<div class="flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 dark:border-black/25 rounded-t-md">
				<h5 class="text-xl font-medium leading-normal">{{ $title }}</h5>
				<x-text-button @click="open = false" aria-label="Close" close />
			</div>
			<div class="relative p-4">
				{{ $slot }}
			</div>
			<div class="flex flex-shrink-0 flex-wrap items-center justify-end gap-2 p-4 border-t border-gray-200 dark:border-black/25 rounded-b-md">
				<x-secondary-button @click="open = false">
					{{ __('Abbrechen') }}
				</x-secondary-button>
				{{ $action }}
			</div>
		</div>
	</div>
</div>
