<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message_id' => $this->id,
            'user_id' => $this->user_id,
            'room_id' => $this->room_id,
            'name_in_forum' => User::findOrFail($this->user_id)->name_in_forum,
            'content' => $this->content,
        ];
    }
}
