<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="flex items-center">
                <x-application-logo class="w-14 h-14 sm:w-20 sm:h-20 fill-transparent stroke-current stroke-1 text-teal-600" />
                <span class="text-teal-600 text-3xl sm:text-5xl">{{ config('app.name', 'StundenCheck') }}</span>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- First Name -->
            <x-text-input
                id="firstname"
                class="block w-full"
                type="text"
                name="firstname"
                :label="__('Vorname')"
                :value="old('firstname')"
                required
                autofocus
            />
            <!-- Last Name -->
            <x-text-input
                id="lastname"
                class="block mt-4 w-full"
                type="text"
                name="lastname"
                :label="__('Nachname')"
                :value="old('lastname')"
                required
            />
            <!-- Email Address -->
            <x-text-input
                id="email"
                class="block mt-4 w-full"
                type="email"
                name="email"
                :label="__('E-Mail-Adresse')"
                :value="old('email')"
                required
            />
            <!-- Password -->
            <x-text-input
                id="password"
                class="block mt-4 w-full"
                type="password"
                name="password"
                :label="__('Passwort')"
                required
            />
            <!-- Confirm Password -->
            <x-text-input
                id="password_confirmation"
                class="block mt-4 w-full"
                type="password"
                name="password_confirmation"
                :label="__('Passwort bestätigen')"
                required
            />

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Bereits registriert?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Registrieren') }}
                </x-primary-button>
            </div>
        </form>

        <x-slot name="credits">
            @include('layouts.credits')
        </x-slot>
    </x-auth-card>
</x-guest-layout>
