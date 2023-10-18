<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "category_id" => $this->category_id,
            "created_at" => $this->created_at->format("d-m-Y"),
            "updated_at" => $this->updated_at->format("d-m-Y"),
        ];
    }
}
