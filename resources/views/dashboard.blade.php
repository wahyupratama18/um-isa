<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 gap-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Positions</h2>
                <div class="text-gray-900 dark:text-gray-100 text-lg">
                    {{ $position }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Enrolled Candidates</h2>
                <div class="text-gray-900 dark:text-gray-100 text-lg">
                    {{ $candidate }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
