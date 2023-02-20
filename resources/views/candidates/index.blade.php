<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Candidates of ').$position->name.' Position' }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{form: ''}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                @can('create', \App\Models\Candidate::class)
                <a href="{{ route('positions.candidates.create', $position) }}">
                    <x-primary-button>
                        {{ __('Add candidate') }}
                    </x-primary-button>
                </a>
                @endcan
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($position->candidates as $candidate)
                    <x-candidates :candidate="$candidate">
                        <x-slot:actions>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @can('update', $candidate)
                                <a href="{{ route('positions.candidates.edit', [$position, $candidate]) }}">
                                    <x-secondary-button class="w-full">
                                        Edit
                                    </x-secondary-button>
                                </a>
                                @endcan
        
                                @can('delete', $position)
                                <x-danger-button
                                    x-data=""
                                    x-on:click.prevent="
                                    $dispatch('open-modal', 'confirm-candidate-deletion')
                                    form = '{{ route('positions.candidates.destroy', [$position, $candidate]) }}'
                                    "
                                >{{ __('Delete') }}</x-danger-button>
                                @endcan
                            </div>
                        </x-slot>
                    </x-candidates>
                @endforeach
            </div>
        </div>

        <x-modal name="confirm-candidate-deletion" focusable>
            <form id="candidate-delete-form" method="post" :action="form" class="p-6">
                @csrf
                @method('delete')
    
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete this?') }}
                </h2>
    
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once it\'s deleted, this candidates and associated votes will be permanently deleted and can\'t be restored.') }}
                </p>
    
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
    
                    <x-danger-button class="ml-3">
                        {{ __('Delete Candidate') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>

</x-app-layout>
