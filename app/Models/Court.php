<?php

namespace App\Models;

use App\Enums\CourtType;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected  $fillable = [
        'name',
        'price',
        'image',
        'type',
        'slug',
    ];

    protected $casts = [
        'type' => CourtType::class,
    ];
    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }
}
