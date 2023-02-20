<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected const ROLES = [
        1 => 'Admin',
        2 => 'Committee',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roleName(): Attribute
    {
        return Attribute::make(get: fn () => self::ROLES[$this->role]);
    }

    public function isAdmin(): bool
    {
        return $this->role === 1;
    }

    public function isCommittee(): bool
    {
        return $this->role === 2;
    }

    /**
     * Get all of the ballots for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ballots(): HasMany
    {
        return $this->hasMany(Ballot::class);
    }
}
