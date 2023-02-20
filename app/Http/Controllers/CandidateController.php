<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;
use App\Models\Candidate;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Position $position): View
    {
        return view('candidates.index', [
            'position' => $position->load('candidates'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Position $position): View
    {
        return view('candidates.create', [
            'position' => $position->load('candidates'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCandidateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCandidateRequest $request, Position $position): RedirectResponse
    {
        $candidate = $position->candidates()
        ->create($request->validated());

        if ($request->photo) {
            $candidate->updatePhoto($request->photo);
        }

        return redirect()->route('positions.candidates.index', $position);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position, Candidate $candidate)/* : View */
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position, Candidate $candidate): View
    {
        return view('candidates.edit', [
            'position' => $position,
            'candidate' => $candidate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCandidateRequest  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCandidateRequest $request, Position $position, Candidate $candidate): RedirectResponse
    {
        $candidate->update($request->validated());

        if ($request->photo) {
            $candidate->updatePhoto($request->photo);
        } elseif ($request->deletion) {
            $candidate->deletePhoto();
        }

        return redirect()->route('positions.candidates.index', $position);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position, Candidate $candidate)
    {
        $this->authorize('delete', $candidate);

        $candidate->delete();

        return redirect()->route('positions.candidates.index', $position);
    }
}
