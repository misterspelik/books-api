<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinesRead extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
