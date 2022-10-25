<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Program extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'status',
        'program_type',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'program_id');
    }
    
    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'assessments');
    }

    public function program_type()
    {
        return $this->belongsTo(ProgramType::class, 'program_type');
    }
}
