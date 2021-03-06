<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question_id' => $this->question_id,
            'body' => $this->body,
            'body_html' => $this->body_html,
            'is_best' => $this->is_best,
            'votes_count' => $this->votes_count,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'user' => new UserResource($this->user),
            'question_user_id' => $this->question->user_id
        ];
    }
}
