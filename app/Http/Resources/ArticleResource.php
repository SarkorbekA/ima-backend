<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'alias' => $this->resource->alias,
            'is_active' => $this->resource->is_active,
            'side' => $this->resource->side,
            'items' => ItemsResource::collection($this->whenLoaded('items'))
        ];
    }
}
