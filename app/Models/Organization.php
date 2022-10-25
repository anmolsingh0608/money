<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $casts = [
        'code' => 'integer',
    ];

    protected $fillable = [
        'organization_name','address','city','state','zip_code','code','name','contact','gmail'
    ];
    
    public function users() {
        return $this->hasMany(User::class, 'org_code', 'code');
    }
}
