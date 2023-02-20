<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get all of the candidates for the Position
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function unvoted(): Attribute
    {
        return Attribute::make(
            get: fn () => Ballot::query()->count() - $this->candidates->sum('ballots_count')
        );
    }
}
