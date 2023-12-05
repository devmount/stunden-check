<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
	<div>
		{{ $logo }}
	</div>

	<div class="
		w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg
		bg-white dark:bg-gray-700
	">
		{{ $slot }}
	</div>

	<div class="w-full sm:max-w-md">
		{{ $credits }}
	</div>
</div>
