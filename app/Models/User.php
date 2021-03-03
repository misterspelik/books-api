<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Admins scope
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->where('role_id', Role::ADMIN_ROLE);
    }

    /**
     * Readers scope
     */
    public function scopeReaders(Builder $query): Builder
    {
        return $query->where('role_id', Role::READER_ROLE);
    }

    /**
     * Checks if user is admin
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role_id = Role::ADMIN_ROLE;
    }

    /**
     * Checks if user is reader
     * @return bool
     */
    public function isReader(): bool
    {
        return $this->role_id = Role::READER_ROLE;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function lineReads()
    {
        return $this->hasMany(LinesRead::class);
    }

    public function timeReads()
    {
        return $this->hasMany(TimesRead::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
