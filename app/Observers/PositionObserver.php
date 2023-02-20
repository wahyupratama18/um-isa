<?php

namespace App\Observers;

use App\Models\Candidate;
use App\Models\Position;

class PositionObserver
{
    /**
     * Handle the Position "created" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function created(Position $position)
    {
        //
    }

    /**
     * Handle the Position "updated" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function updated(Position $position)
    {
        //
    }

    /**
     * Handle the Position "deleted" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function deleting(Position $position)
    {
        $position->candidates->each(function (Candidate $candidate) {
            $candidate->deletePhoto();
        });

        $position->deleteQuietly();
    }

    /**
     * Handle the Position "restored" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function restored(Position $position)
    {
        //
    }

    /**
     * Handle the Position "force deleted" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function forceDeleted(Position $position)
    {
        //
    }
}
