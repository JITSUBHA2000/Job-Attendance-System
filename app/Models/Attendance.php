<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendances';
    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'check_out_time',
        'is_late',
        'left_early',
        'status',
        'manual_entry_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manualEnteredBy()
    {
        return $this->belongsTo(User::class, 'manual_entry_by');
    }
}
