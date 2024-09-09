<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user_id' => $this->user_id,
            'model_id' => $this->model_id,
            'model_type' => $this->model_type,
            'created_at' => $this->created_at,
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
        ];
    }
}
