<?php

namespace App\Contracts;

use App\DTO\ItemDTO;
use App\Models\Item;
use Illuminate\Pagination\Paginator;

interface IItemRepository
{
    public function getAllItems(): Paginator;
    public function changeStatus(Item $item): void;

    public function getItemById(int $item_id): ?Item;

    public function getItemByAlias(string $itemAlias): ?Item;
    public function createItem(ItemDTO $itemDTO): ?Item;
    public function updateItem(ItemDTO $itemDTO, Item $item): Item;
    public function deleteItem(Item $article): void;
}
