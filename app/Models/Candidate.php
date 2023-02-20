<?php

namespace App\Models;

use App\Actions\CandidatePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Candidate extends Model
{
    use HasFactory, CandidatePhoto;

    protected $fillable = ['name'];

    /**
     * Get the position that owns the Candidate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * The ballots that belong to the Candidate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ballots(): BelongsToMany
    {
        return $this->belongsToMany(Ballot::class);
    }
}
