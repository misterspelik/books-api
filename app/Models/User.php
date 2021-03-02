<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function lineReads()
    {
        return $this->hasMany(LineRead::class);
    }

    public function timeReads()
    {
        return $this->hasMany(TimeRead::class);
    }
}
