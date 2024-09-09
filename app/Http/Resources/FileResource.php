<?php
//
//namespace App\Http\Resources;
//
//use Illuminate\Http\Request;
//use Illuminate\Http\Resources\Json\JsonResource;
//
//class FileResource extends JsonResource
//{
//    /**
//     * Transform the resource into an array.
//     *
//     * @return array<string, mixed>
//     */
//    public function toArray(Request $request): array
//    {
//        return [
//          'id' => $this->id,
//          'mime_type' => $this->mime_type,
//          'size' => number_format($this->size),
//          'path' => asset($this->path),
//        ];
//    }
//}


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'path' => asset($this->path),
            'size' => $this->size,
            'mime_type' => $this->mime_type,
        ];
    }
}
