<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'status',
        'exam_id',
        'obj_id',
        'obj_type',
        'max_attempts',
        'released'
       
        
    ];
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class, 'assessment_id');
    }
}
