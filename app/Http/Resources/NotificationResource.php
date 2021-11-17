<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'notification_id' => $this->id,
            'user_id' => $this->user_id,
            'upvote_id' => $this->upvote_id,
            'comment_id' => $this->comment_id,
            'follow_id' => $this->follow_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
