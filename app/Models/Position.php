<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';

    protected $fillable = [
        'name',
    ];

    // public function employees()
    // {
    //     return $this->hasMany(Position::class);
    // }
}
