<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Question extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'worth',
        'type',
        'options',
        'answer',
        'parent_id',
    ];

    public function exam()
    {
        return $this->belongsToMany(Exam::class, 'exams_questions');
    }

    public function parent()
    {
        return $this->belongsTo(Question::class);
    }

    public function sub_question()
    {
        return $this->hasMany(Question::class, 'parent_id', 'id');
    }
}
