<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Übersicht Stunden') }}
            </h2>
            <x-primary-button>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 fill-transparent stroke-current stroke-2 text-white" viewBox="0 0 24 24">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                {{ __('Neuer Eintrag') }}
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-4 grid-cols-3 justify-between">
            <div class="overflow-hidden shadow-md sm:rounded-lg p-6 text-center text-white bg-slate-600 border-4 border-white">
                Insgesamt
                <div class="text-6xl font-medium">35</div>
                Stunden geleistet
            </div>
            <div class="overflow-hidden shadow-md sm:rounded-lg p-6 text-center text-white bg-teal-600 border-4 border-white">
                Aktuelle Abrechnungsperiode
                <div class="text-6xl font-medium">11</div>
                Stunden geleistet
            </div>
            <div class="overflow-hidden shadow-md sm:rounded-lg p-6 text-center text-white bg-amber-600 border-4 border-white">
                Aktuelle Abrechnungsperiode
                <div class="text-6xl font-medium">13</div>
                Stunden ausstehend
            </div>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 border-b border-gray-200">
                <div class="px-6 pb-4">Geleistete Stunden</div>
                <table class="items-center bg-transparent w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Beschreibung
                            </th>
                            <th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Datum
                            </th>
                            <th class="px-6 bg-slate-50 text-slate-500 align-middle border border-solid border-slate-200 py-3 uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Anzahl Stunden
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="px-6 py-4 align-middle whitespace-nowrap text-left">
                            Rasen gemäht auf gesamten Kita-Gelände
                        </td>
                        <td class="px-6 py-4 align-middle whitespace-nowrap">
                            22. August 2022
                        </td>
                        <td class="px-6 py-4 align-center whitespace-nowrap">
                            4
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 align-middle whitespace-nowrap text-left">
                            Klo geputzt im Fachwerkhaus
                        </td>
                        <td class="px-6 py-4 align-middle whitespace-nowrap">
                            25. August 2022
                        </td>
                        <td class="px-6 py-4 align-center whitespace-nowrap">
                            2
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 align-middle whitespace-nowrap text-left">
                            Holztor repariert
                        </td>
                        <td class="px-6 py-4 align-middle whitespace-nowrap">
                            26. August 2022
                        </td>
                        <td class="px-6 py-4 align-center whitespace-nowrap">
                            2
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
