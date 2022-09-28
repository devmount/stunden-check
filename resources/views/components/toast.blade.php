<div
	class="fixed bottom-4 right-4 bg-teal-600 text-white max-w-s rounded-md shadow-lg p-4"
	x-data="{ show: false }"
	x-show="show"
	x-init="setTimeout(() => show = true, 500);setTimeout(() => show = false, 6000)"
	x-transition
	style="display: none;"
>
	{{ $slot }}
</div>
