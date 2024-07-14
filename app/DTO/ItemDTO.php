<?php

namespace App\DTO;

class ItemDTO
{
    public function __construct(
        private readonly string|null $title,
        private readonly string|null $alias,
        private readonly string|null $is_active,
        private readonly string|null $content,
        private readonly int|null $category_id,
        private readonly int|null $parent_id,
        private readonly string|null $side,
    )
    {

    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function getIsActive(): ?string
    {
        return $this->is_active;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function getSide(): ?string
    {
        return $this->side;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            title: $data['title'] ,
            alias: $data['alias'],
            is_active: $data['is_active'],
            content: $data['content'],
            category_id: $data['category_id'],
            parent_id: $data['parent_id'] ?? null,
            side: $data['side'] ?? null,
        );
    }
}
