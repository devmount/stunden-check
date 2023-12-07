<x-app-layout>
	<x-slot name="header">
		<h2>
			{{ __('Dein Profil') }}
		</h2>
	</x-slot>

	<div class="pt-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-content-card>
				<div class="text-center mt-2 text-3xl font-medium">
					{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
				</div>
				<div class="text-center mt-2 font-light text-sm">
					{{ Auth::user()->email }}
				</div>
				<hr class="mt-8 dark:border-gray-800">
				<div class="p-4 text-center">
					{{ __('Profil erstellt am') }}
					<span class="font-bold">
						{{ date("d. F Y", strtotime(Auth::user()->created_at)) }}
					</span>
				</div>
			</x-content-card>
		</div>
	</div>
</x-app-layout>
