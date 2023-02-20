<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBallotRequest;
use App\Http\Requests\UpdateBallotRequest;
use App\Models\Ballot;
use App\Models\Candidate;
use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BallotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        return view('ballots.index', [
            'ballots' => Ballot::query()
            ->when(
                $request->user()->isCommittee(),
                fn (Builder $query) => $query->where('user_id', $request->user()->id),
            )
            ->with('candidates')
            ->latest()
            ->get(),
            'positions' => Position::query()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('ballots.create', [
            'positions' => Position::query()->with('candidates')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBallotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBallotRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $ballot = $request->user()->ballots()->create();

            $ballot->candidates()->sync($request->chosen);
        });

        return redirect()->route('ballots.index')->with('status', 'saved-ballot');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Http\Response
     */
    public function show(Ballot $ballot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Http\Response
     */
    public function edit(Ballot $ballot): View
    {
        $ballot->load('candidates');
        $positions = Position::query()->with('candidates')->get();

        return view('ballots.edit', [
            'ballot' => $ballot,
            'positions' => $positions,
            'elected' => $positions->map(
                fn (Position $position) => $ballot->candidates
                ->first(fn (Candidate $candidate) => $candidate->position_id === $position->id)?->id ?? null
            )->toJson(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBallotRequest  $request
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBallotRequest $request, Ballot $ballot)
    {
        DB::transaction(function () use ($request, $ballot) {
            $ballot->candidates()->sync($request->chosen);
        });

        return redirect()->route('ballots.index')->with('status', 'ballot-updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ballot $ballot): RedirectResponse
    {
        $this->authorize('delete', $ballot);

        $ballot->delete();

        return redirect()->route('ballots.index')->with('status', 'ballot-deleted');
    }
}
