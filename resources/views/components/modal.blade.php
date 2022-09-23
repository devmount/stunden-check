<div class="relative" x-data="{ open: false }">
    <div @click="open = ! open">
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
        class="bg-slate-800/[.5] fixed top-0 left-0 w-full h-full outline-none overflow-x-hidden overflow-y-auto flex items-center justify-center"
        tabindex="-1"
        aria-hidden="true"
        style="display: none;"
    >
        <div class="relative w-auto pointer-events-none">
            <div class="w-full md:w-auto border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div class="flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">{{ $title }}</h5>
                    <button @click="open = false" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-slate-400 hover:stroke-slate-700 stroke-2" viewBox="0 0 24 24">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
                <div class="relative p-4">
                    {{ $slot }}
                </div>
                <div class="flex flex-shrink-0 flex-wrap items-center justify-end gap-2 p-4 border-t border-gray-200 rounded-b-md">
                    <x-secondary-button @click="open = false">
                        {{ __('Abbrechen') }}
                    </x-secondary-button>
                    {{ $action }}
                </div>
            </div>
        </div>
    </div>
</div>
