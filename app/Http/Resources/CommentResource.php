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
                'id' => $this->id,
                'owner' => new UserResource($user),
                'content' => $this->content,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ];
        } catch (\Exception $e) {
            return [
                "Something wrong happen"
            ];
        }
    }
}
