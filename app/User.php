<?php

namespace App;

use App\Model\Comment;
use App\Model\Post;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Model\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function favorite_posts(){
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function scopeAuthors($query){
        return $query->where('role_id',2);
    }
}
