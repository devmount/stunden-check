<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <label class="font-bold">Name:</label> {{ Auth::user()->name }}
                    </div>
                    <div>
                        <label class="font-bold">E-Mail:</label> {{ Auth::user()->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
