<?php

namespace App\Http\Controllers;

use App\DTO\ArticleDTO;
use App\DTO\ItemDTO;
use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ItemCreateRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ItemsResource;
use App\Http\Services\ArticleService;
use App\Http\Services\ItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ItemService $service
     * @return AnonymousResourceCollection
     */
    public function index(
        ItemService $service,
    ): AnonymousResourceCollection
    {
        $items = $service->index();

        return ItemsResource::collection($items);
    }

    /**
     * Update the specified resource in storage.
     * @param ItemService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function changeStatus(
        ItemService $service,
        int         $id
    ): JsonResponse
    {
        return $service->changeStatus($id);
    }

    /**
     * Display the specified resource.
     * @throws ModelNotFoundException
     */
    public function show(
        ItemService $service,
        int         $id
    ): ItemsResource
    {
        $user = $service->show($id);

        return new ItemsResource($user);
    }

    /**
     * Store a newly created resource in storage.
     * @param ItemCreateRequest $request
     * @param ItemService $service
     * @return JsonResponse
     * @throws DuplicateEntryException
     */
    public function store(
        ItemCreateRequest $request,
        ItemService          $service,
    ): JsonResponse
    {
        $validated = $request->validated();

        return $service->create(ItemDTO::fromArray($validated));
    }

    /**
     * Update the specified resource in storage.
     * @param ItemCreateRequest $request
     * @param ItemService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function update(
        ItemCreateRequest $request,
        ItemService          $service,
        int                  $id
    ): JsonResponse
    {
        $validated = $request->validated();

        return $service->update(ItemDTO::fromArray($validated), $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param ItemService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy(
        ItemService $service,
        int         $id
    ): JsonResponse
    {
        return $service->delete($id);
    }

}
