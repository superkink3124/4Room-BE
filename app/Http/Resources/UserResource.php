<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name_in_forum' => $this->name_in_forum,
            'bio' => $this->bio,
            'facebook_link' => $this->facebook_link,
            'linkedin_link' => $this->linkedin_link,
            'instagram_link' => $this->instagram_link,
            'twitter_link' => $this->twitter_link,
            'follower' => $this->followers->count(),
            'following' => $this->following->count(),
            'avatar_id' => $this->avatar_id
        ];
    }
}
