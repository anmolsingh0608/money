<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Section extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function programs()
    {
        return $this->belongsTo(Program::class);
    }

    public function psurvey()
    {
        return $this->belongsToMany(PSurvey::class)->withPivot('on_completion');
    }
}
