<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $fillable = [
        'slug', 
        'time_in', 
        'time_out',
        'createdBy',
        'updatedBy',
    ];
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->updated_at = null;
        });
    }

}
