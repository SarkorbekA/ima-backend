<?php

namespace App\Repositories;

use App\Contracts\IItemRepository;
use App\DTO\ItemDTO;
use App\Models\Item;
use Illuminate\Pagination\Paginator;

class ItemRepository implements IItemRepository
{
    public function getAllItems(): Paginator
    {
        return Item::simplePaginate(15);
    }

    public function changeStatus(Item $item): void
    {
        $item->is_active = $item->is_active ? 0 : 1;
        $item->save();
    }

    public function getItemById(int $item_id): ?Item
    {
        /** @var Item|null $item */

        $item = Item::query()->find($item_id);

        return $item;
    }

    public function getItemByAlias(string $itemAlias): ?Item
    {
        /** @var Item|null $item */
        $item = Item::query()
            ->where('alias', $itemAlias)
            ->first();

        return $item;
    }

    public function createItem(ItemDTO $itemDTO): ?Item
    {
        $item = new Item();
        $item->title = $itemDTO->getTitle();
        $item->side = $itemDTO->getSide();
        $item->alias = $itemDTO->getAlias();
        $item->content = $itemDTO->getContent();
        $item->category_id = $itemDTO->getCategoryId();
        if ($item->parent_id) {
            $item->parent_id = $itemDTO->getParentId();
        }
        $item->is_active = $itemDTO->getIsActive() == true ? 1 : 0;
        $item->save();

        return $item;
    }

    public function updateItem(ItemDTO $itemDTO, Item $item): Item
    {
        $item->title = $itemDTO->getTitle();
        $item->side = $itemDTO->getSide();
        $item->alias = $itemDTO->getAlias();
        $item->content = $itemDTO->getContent();
        $item->category_id = $itemDTO->getCategoryId();
        if ($item->parent_id) {
            $item->parent_id = $itemDTO->getParentId();
        }
        $item->is_active = $itemDTO->getIsActive() == true ? 1 : 0;
        $item->save();

        return $item;
    }

    public function deleteItem(Item $article): void
    {
        $article->delete();
    }

}
