<?php

namespace App\Http\Services;

use App\Contracts\IItemRepository;
use App\DTO\ItemDTO;
use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Resources\ItemsResource;
use App\Models\Item;
use App\Repositories\ItemRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ItemService
{
    /**
     * @var IItemRepository
     */
    private IItemRepository $repository;

    /**
     *
     */
    public function __construct()
    {
        $this->repository = new ItemRepository();
    }


    /**
     * @return Paginator
     */
    public function index(): Paginator
    {
        return $this->repository->getAllItems();
    }


    /**
     * @param int $id
     * @return Item|JsonResponse
     * @throws ModelNotFoundException
     */
    public function changeStatus(int $id): Item|JsonResponse
    {
        $itemWithId = $this->repository->getItemById($id);

        if ($itemWithId === null) {
            throw new ModelNotFoundException('Запись не найдена');
        }

        $this->repository->changeStatus($itemWithId);

        return response()->json([
            'message' => 'Статус изменён успешно!',
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return ItemsResource
     * @throws ModelNotFoundException
     */
    public function show(int $id): ItemsResource
    {
        $articleWithId = $this->repository->getItemById($id);

        if ($articleWithId === null) {
            throw new ModelNotFoundException('Запись не найдена.');
        }

        return new ItemsResource($articleWithId);
    }

    /**
     * @param ItemDTO $itemDTO
     * @return JsonResponse
     * @throws DuplicateEntryException
     */
    public function create(ItemDTO $itemDTO): JsonResponse
    {
        $itemWithAlias = $this->repository->getItemByAlias($itemDTO->getAlias());

        if ($itemWithAlias !== null) {
            throw new DuplicateEntryException('Статья с таким alias уже существует.');
        }

        $data = $this->repository->createItem($itemDTO);

        return response()->json([
            'message' => "Статья создана успешно!",
            'data' => new ItemsResource($data)
        ], Response::HTTP_OK);
    }

    /**
     * @param ItemDTO $itemDTO
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function update(ItemDTO $itemDTO, int $id): JsonResponse
    {
        $itemWithId = $this->repository->getItemById($id);

        if ($itemWithId === null) {
            throw new ModelNotFoundException('Запись не найдена.');
        }

        $data = new ItemsResource($this->repository->updateItem($itemDTO, $itemWithId));

        return response()->json([
            'message' => "Запись обновлена успешно!",
            'data' => $data,
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return Item|JsonResponse
     * @throws ModelNotFoundException
     */
    public function delete(int $id): Item|JsonResponse
    {
        $itemWithId = $this->repository->getItemById($id);

        if ($itemWithId === null) {
            throw new ModelNotFoundException('Запись не найдена');
        }


        $this->repository->deleteItem($itemWithId);

        return response()->json([
            'message' => 'Запись удалена успешно!',
        ], Response::HTTP_OK);
    }
}
