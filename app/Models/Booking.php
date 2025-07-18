<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'date',
        'time',
        'phone',
        'team_name',
        'user_id',
        'court_id',
    ];
}
