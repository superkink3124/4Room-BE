<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

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

    protected $attributes = [
        "role" => 0
    ];

    // public function follow_source_id() {
    //     return $this->hasMany(Follow::class, "source_id", "user_id");
    // }

    // public function follow_destination_id() {
    //     return $this->hasMany(Follow::class, "target_id", "user_id");
    // }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}