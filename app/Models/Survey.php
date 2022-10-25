<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Single Instance of Survey
class Survey extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','section_id','survey'
    ];


    public function takenBy() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function takeBy() {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
