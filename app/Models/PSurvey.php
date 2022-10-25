<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class PSurvey extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function section()
    {
        return $this->belongsToMany(Section::class)->withPivot('on_completion');
    }
}
