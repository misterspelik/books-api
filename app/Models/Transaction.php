<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Lines scope
     */
    public function scopeLines(Builder $query): Builder
    {
        return $query->where('type', 'lines');
    }

    /**
     * Time scope
     */
    public function scopeTime(Builder $query): Builder
    {
        return $query->where('type','time');
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
