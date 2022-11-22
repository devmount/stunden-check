<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Dein Profil') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">
				<div class="text-center mt-2 text-3xl font-medium">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
				<div class="text-center mt-2 font-light text-sm">{{ Auth::user()->email }}</div>
				<hr class="mt-8">
				<div class="p-4 text-center">
					{{ __('Profil erstellt am') }} <span class="font-bold"> {{ date("d. F Y", strtotime(Auth::user()->created_at)) }}</span>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
