<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
        'name_in_forum',
        'bio',
        'facebook_link',
        'instagram_link',
        'linkedin_link',
        'twitter_link'
    ];

    protected $hidden = array('password', 'role', 'created_at', 'updated_at');

    protected $attributes = [
        "role" => 1
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all posts that owned by user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relationship followers of user.
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'target_id');
    }


    /**
     * Get all followings of user.
     */
    public function followings()
    {
        return $this->hasManyThrough(
            User::class,
            Follow::class,
            'source_id',
            'id',
            'id',
            'target_id'
        );
    }
}
