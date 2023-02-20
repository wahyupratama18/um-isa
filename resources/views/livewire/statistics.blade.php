<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-28 px-12 pb-12" wire:poll.4000ms>
        {{-- Nothing in the world is as soft and yielding as water. --}}
        @foreach ($positions as $position)
            <div>
                <h2 class="text-gray-200 font-bold mb-4">{{ $position->name }}</h2>
    
                <div wire:ignore x-data="{
                    options: {
                        chart: {
                            type: 'bar',
                            height: 300,
                            toolbar: { show: true }
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: { width: 200 },
                                legend: { position: 'bottom' }
                            }
                        }],
                        plotOptions: {
                            {{-- radar: {
                                size: 140,
                                polygons: {
                                    strokeColors: '#e9e9e9',
                                    fill: {
                                        colors: ['#f8f8f8', '#fff']
                                    }
                                }
                            } --}}
                        },
                        theme: {
                            mode: 'dark',
                            palette: 'palette1'
                        },
                        stroke: { curve: 'smooth' },
                        xaxis: {
                            categories: {{ $position->candidates->pluck('name')->push(['Unvoted']) }},
                        },
                        series: [{
                            name: '{{ $position->name }}',
                            data: {{ $position->candidates->pluck('ballots_count')->push([$position->unvoted]) }}
                        }]
                    }
                }" x-init="
                position_{{ $loop->iteration }} = new ApexCharts(document.getElementById('position_{{ $loop->iteration }}'), options)
                position_{{ $loop->iteration }}.render()

                @this.on('refresh-chart', (data) => {

                    candidates = data.positions[{{ $loop->index }}].candidates.map((c) => {
                        return c.ballots_count
                    })

                    candidates.push([
                        data.positions[{{ $loop->index }}].unvoted
                    ])

                    position_{{ $loop->iteration }}.updateSeries([{
                        name: data.positions[{{ $loop->index }}].name,
                        data: candidates
                    }])
                })
                " class="mt-2" id="position_{{ $loop->iteration }}"></div>

                <h4 class="font-semibold text-gray-100">Leaderboard</h4>

                <x-table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Candidate</th>
                            <th>Counts</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Invalid / Unvote</td>
                            <td>{{ $position->unvoted }}</td>
                        </tr>
                        @foreach ($position->candidates->sortByDesc('ballots_count') as $candidate)
                            <tr>
                                <td>{{ 1 + $loop->iteration }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->ballots_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </div>
        @endforeach
    </div>
</div>
