<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Position List') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{form: ''}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8">
                <div class="flex justify-end">
                    @can('create', \App\Models\Position::class)
                    <a href="{{ route('positions.create') }}">
                        <x-primary-button>
                            {{ __('Add position') }}
                        </x-primary-button>
                    </a>
                    @endcan
                </div>

                <x-table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Total Candidates</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($positions as $position)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $position->name }}</td>
                                <td>{{ $position->candidates_count }}</td>
                                <td class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <a href="{{ route('positions.candidates.index', $position) }}">
                                        <x-primary-button class="w-full">Candidates</x-primary-button>
                                    </a>

                                    @can('update', $position)
                                    <a href="{{ route('positions.edit', $position) }}">
                                        <x-secondary-button class="w-full">
                                            Edit
                                        </x-secondary-button>
                                    </a>
                                    @endcan

                                    @can('delete', $position)
                                    <x-danger-button
                                        x-data=""
                                        x-on:click.prevent="
                                        $dispatch('open-modal', 'confirm-position-deletion')
                                        form = '{{ route('positions.destroy', $position) }}'
                                        "
                                    >{{ __('Delete') }}</x-danger-button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="99">No positions available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </x-table>
                
            </div>
        </div>

        <x-modal name="confirm-position-deletion" focusable>
            <form id="position-delete-form" method="post" :action="form" class="p-6">
                @csrf
                @method('delete')
    
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete this?') }}
                </h2>
    
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once it\'s deleted, all of the candidates and associated files will be permanently deleted and can\'t be restored.') }}
                </p>
    
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
    
                    <x-danger-button class="ml-3">
                        {{ __('Delete Position') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>

</x-app-layout>
