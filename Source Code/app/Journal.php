<?php

namespace App;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model implements Searchable
{
    // use Searchable;
    use SoftDeletes;

    protected $guarded = [];

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
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function comments_limit()
    {
        return $this->morphMany('App\Comment', 'commentable')->limit(1)->with('user');
    }

    // public function comments_limit($limit)
    // {
    //     return $this->morphMany('App\Comment', 'commentable')->limit($limit);
    // }

    public function getSearchResult(): SearchResult
    {
        $url = route('journal.show', $this->id);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->description,
            $url
        );
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
}
