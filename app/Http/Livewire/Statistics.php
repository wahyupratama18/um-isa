<?php

namespace App\Http\Livewire;

use App\Models\Position;
use Livewire\Component;

class Statistics extends Component
{
    public function render()
    {
        $positions = Position::query()->with([
            'candidates' => fn ($query) => $query->withCount('ballots'),
        ])->get()
        ->map(function (Position $position) {
            $position->unvoted = $position->unvoted;

            return $position;
        });

        $this->emit('refresh-chart', [
            'positions' => $positions,
        ]);

        return view('livewire.statistics', [
            'positions' => $positions,
        ]);
    }
}
