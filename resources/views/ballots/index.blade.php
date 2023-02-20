<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ballots record') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{form: ''}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                @can('create', \App\Models\Ballot::class)
                <a href="{{ route('ballots.create') }}">
                    <x-primary-button>
                        {{ __('Add record') }}
                    </x-primary-button>
                </a>
                @endcan
            </div>

            <x-table>
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Record Date</th>
                        <th colspan="{{ $positions->count() }}">Selection</th>
                        <th rowspan="2">Action</th>
                    </tr>
                    <tr>
                        @foreach ($positions as $position)
                            <th>{{ $position->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ballots as $ballot)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ballot->created_at->format('F j, Y H:i:s') }}</td>

                            @foreach ($positions as $position)
                                <td>{{ $ballot->candidates->first(fn (\App\Models\Candidate $candidate) => $candidate->position_id ===  $position->id)?->name ?? 'Unvoted' }}</td>
                            @endforeach

                            <td class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                @can('update', $ballot)
                                <a href="{{ route('ballots.edit', $ballot) }}">
                                    <x-secondary-button class="w-full">
                                        Edit
                                    </x-secondary-button>
                                </a>
                                @endcan

                                @can('delete', $ballot)
                                <x-danger-button
                                    x-data=""
                                    x-on:click.prevent="
                                    $dispatch('open-modal', 'confirm-ballots-deletion')
                                    form = '{{ route('ballots.destroy', $ballot) }}'
                                    "
                                >{{ __('Delete') }}</x-danger-button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="99">No votes recorded</td>
                    </tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>

        @if (Auth::user()->isAdmin())
        <x-modal name="confirm-ballots-deletion" focusable>
            <form id="ballots-delete-form" method="post" :action="form" class="p-6">
                @csrf
                @method('delete')
    
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete this record?') }}
                </h2>
    
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once it\'s deleted, this votes will be permanently deleted and can\'t be restored.') }}
                </p>
    
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
    
                    <x-danger-button class="ml-3">
                        {{ __('Delete Ballot') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
        @endif
    </div>

</x-app-layout>
