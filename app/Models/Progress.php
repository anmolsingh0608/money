<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;
    protected $table = 'progress';
    protected $fillable = [
        'user_id',
        'program_id',
        'section_id',
        'status',
        'percentage',
    ];
}
