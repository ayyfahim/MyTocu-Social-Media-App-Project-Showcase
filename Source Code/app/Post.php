<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Searchable\Searchable;
use Spatie\Sluggable\SlugOptions;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements Searchable
{
    use SoftDeletes, HasSlug;

    protected $fillable = [
        'user_id', 'title', 'description', 'post_image', 'liste_id',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function list()
    {
        return $this->belongsTo(Liste::class, 'list_id');
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

    public function getSearchResult(): SearchResult
    {
        $url = route('post.show', $this->id);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
    protected static function booted()
    {
        static::deleted(function ($post) {
            $file = [
            storage_path('uploads/posts/' . $post->post_image),
            ];
            File::delete($file);
        });
    }
     */
}
