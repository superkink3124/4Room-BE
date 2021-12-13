<?php

namespace App\Http\Resources;

use App\Models\Upvote;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $record = NULL;
        $name_in_forum = NULL;
        $avatar_id = NULL;
        $upvote_model = NULL;
        $comment_model = NULL;
        $follow_model = NULL;
        if(!is_null($this->upvote_id)) {
            $upvote_model = Upvote::where("id", $this->upvote_id)->first();
            $record = [
                'user_id' => $upvote_model->user_id,
                'post_id' => $upvote_model->post_id,
                'created_at' => $upvote_model->created_at,
                'updated_at' => $upvote_model->updated_at
            ];
            $user_model = User::where("id", $record['user_id'])->first();
            $name_in_forum = $user_model->name_in_forum;
            $avatar_id = $user_model->avatar_id;
        } else if(!is_null($this->comment_id)) {
            $comment_model = Comment::where("id", $this->comment_id)->first();
            $record = [
                'user_id' => $comment_model->user_id,
                'post_id' => $comment_model->post_id,
                'created_at' => $comment_model->created_at,
                'updated_at' => $comment_model->updated_at
            ];
            $user_model = User::where("id", $record['user_id'])->first();
            $name_in_forum = $user_model->name_in_forum;
            $avatar_id = $user_model->avatar_id;
        } else if(!is_null($this->follow_id)) {
            $follow_model = Follow::where("id", $this->follow_id)->first();
            $record = [
                'user_id' => $follow_model->source_id,
                'created_at' => $follow_model->created_at,
                'updated_at' => $follow_model->updated_at
            ];
            $user_model = User::where("id", $record['user_id'])->first();
            $name_in_forum = $user_model->name_in_forum;
            $avatar_id = $user_model->avatar_id;
        }
        return [
            'notification_id' => $this->id,
            'user_id' => $this->user_id,
            'upvote_id' => $this->upvote_id,
            'comment_id' => $this->comment_id,
            'follow_id' => $this->follow_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'record' => $record,
            'name_in_forum' => $name_in_forum,
            'avatar_id' => $avatar_id,
            'upvote_model' => $upvote_model,
            'comment_model' => $comment_model,
            'follow_model' => $follow_model
        ];
    }
}
