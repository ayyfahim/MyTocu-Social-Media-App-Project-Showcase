<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Liste extends Model
{
    use SoftDeletes, HasSlug;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lists';

    protected $fillable = [
        'user_id', 'title', 'post_id'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'list_id');
    }

    public function latestPosts()
    {
        return $this->hasMany(Post::class, 'list_id')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userWithTrashed()
    {
        return $this->user()->withTrashed();
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

    public function comments_limit()
    {
        return $this->morphMany('App\Comment', 'commentable')->limit(1)->with('user');
    }

    // public function comments_limit($limit)
    // {
    //     return $this->morphMany('App\Comment', 'commentable')->limit($limit);
    // }
}
