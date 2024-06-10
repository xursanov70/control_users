<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_work',
        'end_work',
        'on_time_start',
        'on_time_end',
        'late',
        'early',
        'active',
    ];
}
