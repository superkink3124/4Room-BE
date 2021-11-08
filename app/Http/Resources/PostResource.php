<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class PostResource extends JsonResource
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
            'post_id' => $this->id,
            'owner_id' => $this->user_id,
            'content' => $this->content,
            'upvote' => $this->upvotes->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'file' => $this->file,
            'comment' => $this->comments()->simplePaginate(1)
        ];
    }
}
