<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Post;

class Tag extends Model
{
    protected $guarded = [];

     public function posts(){
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
