<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemsResource extends JsonResource
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
            'category_id' => $this->resource->category_id,
            'parent_id' => $this->resource->category_id,
            'is_active' => $this->resource->is_active == 1,
            'side' => $this->resource->side,
            'alias' => $this->resource->alias,
            'content' => $this->resource->content,
        ];
    }
}
