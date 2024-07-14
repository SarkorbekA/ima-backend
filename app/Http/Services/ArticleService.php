<?php

namespace App\Http\Services;

use App\Contracts\IArticleRepository;
use App\Contracts\IUserRepository;
use App\DTO\ArticleDTO;
use App\DTO\UserDTO;
use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\User;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class ArticleService
{
    /**
     * @var IArticleRepository
     */
    private IArticleRepository $repository;

    /**
     *
     */
    public function __construct()
    {
        $this->repository = new ArticleRepository();
    }


    /**
     * @return Paginator
     */
    public function index(): Paginator
    {
        return $this->repository->getAllArticles();
    }

    /**
    * @return Collection
     */
    public function getCategoryIds(): Collection
    {
        return $this->repository->getAllIds();
    }



    /**
     * @param int $id
     * @return Category|JsonResponse
     * @throws ModelNotFoundException
     */
    public function changeStatus(int $id): Category|JsonResponse
    {
        $articleWithId = $this->repository->getArticleById($id);

        if ($articleWithId === null) {
            throw new ModelNotFoundException('Запись не найдена');
        }

        $this->repository->changeStatus($articleWithId);

        return response()->json([
            'message' => 'Статус изменён успешно!',
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return ArticleResource
     * @throws ModelNotFoundException
     */
    public function show(int $id): ArticleResource
    {
        $articleWithId = $this->repository->getArticleById($id);

        if ($articleWithId === null) {
            throw new ModelNotFoundException('Запись не найдена.');
        }


        return new ArticleResource($articleWithId);
    }

    /**
     * @param ArticleDTO $articleDTO
     * @return JsonResponse
     * @throws DuplicateEntryException
     */
    public function create(ArticleDTO $articleDTO): JsonResponse
    {
        $articleWithAlias = $this->repository->getArticleByAlias($articleDTO->getAlias());

        if ($articleWithAlias !== null) {
            throw new DuplicateEntryException('Артикль с таким alias уже существует.');
        }

        $data = $this->repository->createArticle($articleDTO);

        return response()->json([
            'message' => "Артикль создан успешно!",
            'data' => new ArticleResource($data)
        ], Response::HTTP_OK);
    }

    /**
     * @param ArticleDTO $articleDTO
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function update(ArticleDTO $articleDTO, int $id): JsonResponse
    {
        $articleWithId = $this->repository->getArticleById($id);

        if ($articleWithId === null) {
            throw new ModelNotFoundException('Запись не найдена.');
        }

        $data = new ArticleResource($this->repository->updateArticle($articleDTO, $articleWithId));

        return response()->json([
            'message' => "Запись обновлена успешно!",
            'data' => $data,
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return Category|JsonResponse
     * @throws ModelNotFoundException
     */
    public function delete(int $id): Category|JsonResponse
    {
        $articleWithId = $this->repository->getArticleById($id);

        if ($articleWithId === null) {
            throw new ModelNotFoundException('Запись не найдена');
        }


        $this->repository->deleteArticle($articleWithId);

        return response()->json([
            'message' => 'Запись удалена успешно!',
        ], Response::HTTP_OK);
    }
}
