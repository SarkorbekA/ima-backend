<?php

namespace App\Http\Controllers;

use App\DTO\ArticleDTO;
use App\DTO\UserDTO;
use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\ArticleBaseResource;
use App\Http\Resources\ArticleResource;
use App\Http\Services\ArticleService;
use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ArticleService $service
     * @return AnonymousResourceCollection
     */
    public function index(
        ArticleService $service,
    ): AnonymousResourceCollection
    {
        $articles = $service->index();

        return ArticleResource::collection($articles);
    }

    /**
     * Display a listing of the resource.
     * @param ArticleService $service
     * @return Collection
     */
    public function getCategories(
        ArticleService $service,
    )
    {
        return $service->getCategoryIds();
    }

    /**
     * Update the specified resource in storage.
     * @param ArticleService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function changeStatus(
        ArticleService $service,
        int            $id
    ): JsonResponse
    {
        return $service->changeStatus($id);
    }

    /**
     * Display the specified resource.
     * @throws ModelNotFoundException
     */
    public function show(
        ArticleService $service,
        int            $id
    ): ArticleResource
    {
        $article = $service->show($id);

        return new ArticleResource($article);
    }

    /**
     * Store a newly created resource in storage.
     * @param ArticleCreateRequest $request
     * @param ArticleService $service
     * @return JsonResponse
     * @throws DuplicateEntryException
     */
    public function store(
        ArticleCreateRequest $request,
        ArticleService       $service,
    ): JsonResponse
    {
        $validated = $request->validated();

        return $service->create(ArticleDTO::fromArray($validated));
    }

    /**
     * Update the specified resource in storage.
     * @param ArticleCreateRequest $request
     * @param ArticleService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function update(
        ArticleCreateRequest $request,
        ArticleService       $service,
        int                  $id
    ): JsonResponse
    {
        $validated = $request->validated();

        return $service->update(ArticleDTO::fromArray($validated), $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param ArticleService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy(
        ArticleService $service,
        int            $id
    ): JsonResponse
    {
        return $service->delete($id);
    }

}
