<?php

namespace App\Models;

use App\Enums\PlatformType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
    ];
    protected $casts = [
        'type' => PlatformType::class,
    ];

    public function posts() {
        return $this->belongsToMany(Post::class, 'post_platforms');
    }
    public function users()
{
    return $this->belongsToMany(User::class, 'user_platforms');
}
 

   

}
