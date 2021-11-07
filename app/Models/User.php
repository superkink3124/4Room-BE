<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * Get all posts that owned by this user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all followers of this user.
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'target_id');
    }

    /**
     * Get all followings of this user.
     */
    public function followings(): HasMany
    {
        return $this->hasMany(Follow::class, 'source_id');
    }
}
