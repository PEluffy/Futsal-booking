<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['name', 'desc'];

    public function courts()
    {
        return $this->belongsToMany(Court::class);
    }
}
