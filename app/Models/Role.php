<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    public const ADMIN = 'admin';
    public const USER = 'student'; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
