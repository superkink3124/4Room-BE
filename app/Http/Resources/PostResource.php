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
        $user = User::findOrFail($this->user_id);
        return [
            'id' => $this->id,
            'owner' => new UserResource($user),
            'title' => $this->title,
            'content' => $this->content,
            'upvote' => $this->upvotes->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'file' => new FileResource($this->file),
            'comments' => CommentResource::collection($this->comments)
        ];
    }
}
