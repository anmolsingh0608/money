<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'total_score',
        'passing_score',
    ];

    public function question()
    {
        return $this->belongsToMany(Question::class, 'exams_questions')->withPivot('sequence');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'assessments');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'exam_id');
    }
}
