<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'name_in_forum' => User::findOrFail($this->user_id)->name_in_forum,
            'content' => $this->content,
            'upvote' => $this->upvotes->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'file' => new FileResource($this->file),
            'comment' => CommentResource::collection($this->comments)
        ];
    }
}
