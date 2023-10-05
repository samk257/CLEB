<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTutor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_tutoring_id',
        'courses',
        'class',
        'school_attend',
        'days',
        'hours',
        'phone_number',
        'address',
        'description',
        'status',
    ];
}
