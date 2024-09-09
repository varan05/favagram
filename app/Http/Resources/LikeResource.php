<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'like_count' => $this->likesCount,
             'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'user_liked' => $request->user() ? $this->post->likedByUser($request->user()->id) : false,

        ];
    }
}
