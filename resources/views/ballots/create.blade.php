<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Save ballots') }}
        </h2>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Save ballots') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Save elected candidates of UM ISA.') }}
                    </p>

                    <x-validation-errors :errors="$errors" />
                </header>
            </div>
        
            <form method="post" action="{{ route('ballots.store') }}" class="mt-6 space-y-6 p-4" enctype="multipart/form-data"
            x-data="{
                elected: {{ $positions->map(fn ($position) => null)->toJson() }},
            }"
            >
                @csrf
        
                @foreach ($positions as $position)
                    <x-text-input name="elected[]" type="hidden" x-model="elected[{{ $loop->index }}]" />
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $position->name }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                            @foreach ($position->candidates as $candidate)
                                <x-candidates :candidate="$candidate">
                                    <x-slot:actions>
                                        <div class="mt-4 flex justify-end">
                                            <x-primary-button type="button" @click="elected[{{ $loop->parent->index }}] = {{ $candidate->id }}">
                                                <span x-text="elected[{{ $loop->parent->index }}] === {{ $candidate->id }} ? 'Elected' : 'Elect'"></span>
                                            </x-primary-button>
                                        </div>
                                    </x-slot>
                                </x-candidates>
                            @endforeach
                            <x-candidates :candidate="(object) ['photo' => 'https://ui-avatars.com/api/?name=Invalid%20Vote&color=7F9CF5&background=EBF4FF', 'name' => 'Invalid Vote']">
                                <x-slot:actions>
                                    <div class="mt-4 flex justify-end">
                                        <x-primary-button type="button" @click="elected[{{ $loop->index }}] = null;">
                                            <span x-text="elected[{{ $loop->index }}] === null ? 'Marked as invalid' : 'Void / Invalid'"></span>
                                        </x-primary-button>
                                    </div>
                                </x-slot>
                            </x-candidates>
                        </div>
                    </div>
                @endforeach
        
                <div class="flex items-center justify-end gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
        
                    @if (session('status') === 'position-stored')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </section>
</x-app-layout>

