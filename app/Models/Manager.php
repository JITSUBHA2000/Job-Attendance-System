<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use SoftDeletes;

    protected $table = 'manager';

    protected $fillable = [
        'user_id',
        'join_date',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
