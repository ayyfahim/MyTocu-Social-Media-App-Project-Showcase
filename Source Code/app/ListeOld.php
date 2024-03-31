<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListeOld extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'post_id'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function latestPosts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

    public function comments_limit($limit)
    {
        return $this->morphMany('App\Comment', 'commentable')->limit($limit);
    }
}
