<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        try {
            $user = User::findOrFail($this->user_id);
            return [
                'comment_id' => $this->id,
                'content' => $this->content,
                'user_id' => $this->user_id,
                'name_in_forum' => $user->name_in_forum,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'avatar_id' => $user->avatar_id
            ];
        } catch (\Exception $e) {
            return [
                "Something wrong happen"
            ];
        }
    }
}
