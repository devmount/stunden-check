<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
	<!-- Primary Navigation Menu -->
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<div class="flex">
				<!-- Logo -->
				<div class="shrink-0 flex items-center">
					<a href="{{ route('dashboard') }}" class="transition-colors text-teal-600 hover:text-teal-400">
						<x-application-logo class="w-12 h-12 fill-transparent stroke-current stroke-1" />
					</a>
				</div>

				<!-- Navigation Links -->
				<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
					<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
						{{ __('Stunden') }}
					</x-nav-link>
					@if (Auth::user()->is_admin)
						<x-nav-link :href="route('accounts')" :active="request()->is('accounts*')">
							{{ __('Konten') }}
						</x-nav-link>
						<x-nav-link :href="route('settings')" :active="request()->is('settings*')">
							{{ __('Einstellungen') }}
						</x-nav-link>
					@endif
				</div>
			</div>

			<!-- Settings Dropdown -->
			<div class="hidden sm:flex sm:items-center sm:ml-6">
				<x-dropdown align="right" width="48">
					<x-slot name="trigger">
						<button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 hover:dark:text-white hover:border-gray-300 hover:dark:border-gray-500 focus:text-gray-700 focus:dark:text-white focus:border-gray-300 focus:dark:border-gray-500 transition-colors">
							<div>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>

							<div class="ml-1">
								<svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
								</svg>
							</div>
						</button>
					</x-slot>

					<x-slot name="content">
						<x-dropdown-link :href="route('profile')">
							{{ __('Profil') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('password.change')">
							{{ __('Passwort ändern') }}
						</x-dropdown-link>

						<!-- Authentication -->
						<form method="POST" action="{{ route('logout') }}">
							@csrf
							<x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
								{{ __('Log Out') }}
							</x-dropdown-link>
						</form>
					</x-slot>
				</x-dropdown>
			</div>

			<!-- Hamburger -->
			<div class="-mr-2 flex items-center sm:hidden">
				<button
					@click="open = !open"
					class="
						inline-flex items-center justify-center p-2 rounded-md focus:outline-none transition
						text-gray-400 hover:text-gray-500 hover:dark:text-white hover:bg-gray-100 hover:dark:bg-gray-600 focus:text-gray-500 focus:dark:text-white focus:bg-gray-100 focus:dark:bg-gray-600
					"
				>
					<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
						<path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
						<path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
		</div>
	</div>

	<!-- Responsive Navigation Menu -->
	<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
		<div class="pt-2 pb-3 space-y-1">
			<x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
				{{ __('Stunden') }}
			</x-responsive-nav-link>
			<x-responsive-nav-link :href="route('accounts')" :active="request()->routeIs('accounts')">
				{{ __('Konten') }}
			</x-responsive-nav-link>
			<x-responsive-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
				{{ __('Einstellungen') }}
			</x-responsive-nav-link>
		</div>

		<!-- Responsive Settings Options -->
		<div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
			<x-responsive-nav-link :href="route('profile')" :active="request()->routeIs('profile')" class="px-4">
				<div class="font-medium text-base">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
				<div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
			</x-responsive-nav-link>
			<x-responsive-nav-link :href="route('password.change')">
				{{ __('Passwort ändern') }}
			</x-responsive-nav-link>

			<div class="mt-3 space-y-1">
				<!-- Authentication -->
				<form method="POST" action="{{ route('logout') }}">
					@csrf

					<x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
						{{ __('Log Out') }}
					</x-responsive-nav-link>
				</form>
			</div>
		</div>
	</div>
</nav>
