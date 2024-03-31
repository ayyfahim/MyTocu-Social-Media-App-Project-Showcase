<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Searchable\Searchable;
use Spatie\Sluggable\SlugOptions;

use Spatie\Searchable\SearchResult;
use Illuminate\Notifications\Notifiable;
use Demency\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Searchable, MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasSlug, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'birthdate', 'user_image', 'country_id', 'state_id', 'city_id', 'status', 'invited_by'
    ];

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

    public function getSearchResult(): SearchResult
    {
        $url = route('user.show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
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


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($user) {
            $user->lists()->delete();
            $user->posts()->delete();
            $user->journals()->delete();
        });

        static::restoring(function ($user) {
            $user->lists()->withTrashed()->restore();
            $user->posts()->withTrashed()->restore();
            $user->journals()->withTrashed()->restore();
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function lists()
    {
        return $this->hasMany(Liste::class)->latest();
    }

    public function journals()
    {
        return $this->hasMany(Journal::class)->latest();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }

        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }

        return false;
    }

    public function birthDay()
    {
        return \Carbon\Carbon::parse($this->birthdate)->format('d');
    }

    public function birthMonth()
    {
        return \Carbon\Carbon::parse($this->birthdate)->format('m');
    }

    public function birthYear()
    {
        return \Carbon\Carbon::parse($this->birthdate)->format('Y');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function isPrivate()
    {
        if ($this->status != 1) {
            return false;
        }

        return true;
    }
}
