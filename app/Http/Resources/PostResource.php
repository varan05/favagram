<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $userId = $request->user() ? $request->user()->id : null;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'likesCount' => $this->likesCount,
            'is_liked' => $userId ? $this->resource->likedByUser($userId) : false,
            'user' => new UserResource($this->whenLoaded('user')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
