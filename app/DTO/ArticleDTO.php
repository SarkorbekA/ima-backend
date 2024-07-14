<?php

namespace App\DTO;

class ArticleDTO
{
    public function __construct(
        private readonly string|null $title,
        private readonly string|null $alias,
        private readonly string|null $is_active,
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

    public function getSide(): ?string
    {
        return $this->side;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            title: $data['title'] ?? null,
            alias: $data['alias'] ?? null,
            is_active: $data['is_active'] ?? null,
            side: $data['side'] ?? null,
        );
    }
}
