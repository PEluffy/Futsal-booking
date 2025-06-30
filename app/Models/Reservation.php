<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'court_id',
        'date',
        'time',
        'reserved_at',
    ];
}
